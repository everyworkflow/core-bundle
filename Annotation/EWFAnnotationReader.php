<?php

/**
 * @copyright EveryWorkflow. All rights reserved.
 */

declare(strict_types=1);

namespace EveryWorkflow\CoreBundle\Annotation;

use Doctrine\Common\Annotations\Reader;
use EveryWorkflow\CoreBundle\Cache\EWFCache;
use EveryWorkflow\CoreBundle\Message\MessageInterface;
use Opis\JsonSchema\Schema;
use Opis\JsonSchema\ValidationError;
use Opis\JsonSchema\Validator;
use Psr\Log\LoggerInterface;
use ReflectionClass;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class EWFAnnotationReader implements EWFAnnotationReaderInterface
{
    private Reader $reader;
    protected array $errorMessage;
    private LoggerInterface $logger;
    private AdapterInterface $cache;
    private EWFCache $EWFCache;
    private MessageInterface $message;

    public function __construct(Reader $reader, LoggerInterface $logger, EWFCache $EWFCache, MessageInterface $message)
    {
        $this->reader = $reader;
        $this->logger = $logger;
        $this->EWFCache = $EWFCache;
        $this->message = $message;
    }

    /**
     * @param $className
     */
    public function getDocumentClass(object $className): string
    {
        try {
            $className = get_class($className);
            $classAnnotation = $this->reader->getClassAnnotation(
                new ReflectionClass($className),
                "\EveryWorkflow\CoreBundle\Annotation\RepoDocument"
            );
            if ($classAnnotation) {
                return $classAnnotation->doc_name;
            }
        } catch (\ReflectionException $e) {
        }

        return '\EveryWorkflow\MongoBundle\Document\BaseDocument';
    }

    /**
     * @param $classObject
     *
     * @return false|string
     *
     * @throws \ReflectionException
     */
    public function getDocumentSchema(object $classObject)
    {
        $documentClass = $this->getDocumentClass($classObject);
        $schemaInfo = $this->EWFCache->getItem('document_schema' . $documentClass);

        /* check if schema available in cache */
        if (!$schemaInfo->isHit()) {
            $schemaProperties = [];
            $requiredField = [];
            $classObject = new \ReflectionClass($documentClass);

            foreach ($classObject->getMethods() as $method) {
                if (str_starts_with($method->getName(), 'set')) {
                    $methodAnnotation = $this->reader->getMethodAnnotation($method, "\EveryWorkflow\CoreBundle\Annotation\EWFDataTypes");
                    $schemaPropertie = [];
                    if (is_object($methodAnnotation)) {
                        $this->getMethodAnnotationData($methodAnnotation, 'type', $schemaPropertie);
                        $this->getMethodAnnotationData($methodAnnotation, 'minLength', $schemaPropertie);
                        $this->getMethodAnnotationData($methodAnnotation, 'maxLength', $schemaPropertie);
                        $this->castDataTypes($schemaPropertie);
                        if ($hasMongoFiled = $this->getMethodAnnotationData($methodAnnotation, 'mongofield')) {
                            $schemaProperties[$hasMongoFiled] = $schemaPropertie;
                        } else {
                            $hasMongoFiled = $this->uncamelCase(ltrim($method->getName(), 'set'));
                            $schemaProperties[$hasMongoFiled] = $schemaPropertie;
                        }

                        if ($required = $this->getMethodAnnotationData($methodAnnotation, 'required') && $hasMongoFiled) {
                            $requiredField[] = $hasMongoFiled;
                        }
                    }
                }
            }
            $this->logger->info(print_r($schemaProperties, true));

            $jsonSchema = $this->getJsonSchema($schemaProperties, $requiredField);
            /* save data to cache */
            $schemaInfo->set($jsonSchema);
            $this->EWFCache->save($schemaInfo);
        }

        return $schemaInfo->get();
    }

    /**
     * @todo manage exception
     */
    public function validateData(array $data, object $classObject): bool
    {
        $document = json_decode(json_encode($data));
        $schema = Schema::fromJsonString($this->getDocumentSchema($classObject));
        $validator = new Validator();
        $result = $validator->schemaValidation($document, $schema, 10000);
        $this->errorMessage = [];
        if (!$result->isValid()) {
            /** @var ValidationError $error */
            $errors = $result->getErrors();
            foreach ($errors as $error) {
                switch ($error->keyword()) {
                    case 'type':
                        $this->message->addErrorMessage('Expected ' . $error->keywordArgs()['expected'] . ' but used ' . $error->keywordArgs()['used'] .
                            ' for `' . implode(', ', $error->dataPointer()) . '`');
                        break;

                    case 'maxLength':
                        $this->message->addErrorMessage('Expected maxLength ' . $error->keywordArgs()['max'] . ' but given ' . $error->keywordArgs()['length'] .
                            ' for `' . implode(', ', $error->dataPointer()) . '`');
                        break;
                    case 'minLength':
                        $this->message->addErrorMessage('Expected maxLength ' . $error->keywordArgs()['min'] . ' but given ' . $error->keywordArgs()['length'] .
                            ' for `' . implode(', ', $error->dataPointer()) . '`');
                        break;
                }
            }

            return false;
        }

        return true;
    }

    /**
     * @param $methodAnnotation
     * @param $property
     * @param null $referanceVariable
     *
     * @return mixed
     */
    private function getMethodAnnotationData(object $methodAnnotation, string $property, &$referanceVariable = null)
    {
        if (property_exists($methodAnnotation, $property) && $methodAnnotation->{$property}) {
            if (is_array($referanceVariable)) {
                $referanceVariable[$property] = $methodAnnotation->{$property};
            }

            return $methodAnnotation->{$property};
        }
    }

    /**
     * @param $str
     *
     * @return string
     */
    public function camelCase($str)
    {
        $i = ['-', '_'];
        $str = preg_replace('/([a-z])([A-Z])/', '\\1 \\2', $str);
        $str = preg_replace('@[^a-zA-Z0-9\-_ ]+@', '', $str);
        $str = str_replace($i, ' ', $str);
        $str = str_replace(' ', '', ucwords(strtolower($str)));
        $str = strtolower(substr($str, 0, 1)) . substr($str, 1);

        return $str;
    }

    /**
     * @param $str
     *
     * @return string|string[]
     */
    public function uncamelCase(string $str)
    {
        $str = preg_replace('/([a-z])([A-Z])/', '\\1_\\2', $str);
        $str = strtolower($str);

        return str_replace(' ', '_', $str);
    }

    /**
     * @param $property
     * @param $required
     * @param (mixed|string|string[])[] $required
     *
     * @return false|string
     */
    private function getJsonSchema(array $property, array $required)
    {
        $returnArray['$schema'] = 'http://json-schema.org/draft-07/schema#';
        $returnArray['$id"'] = 'http://everyworkflow.com/scope.json#';
        $returnArray['type'] = 'object';
        $returnArray['properties'] = $property;
        $returnArray['required'] = $required;
        $returnArray['additionalProperties'] = true;

        return json_encode($returnArray);
    }

    /**
     * @param $schemaPropertie
     */
    private function castDataTypes(&$schemaPropertie): void
    {
        if (isset($schemaPropertie['type'])) {
            switch ($schemaPropertie['type']) {
                case 'datetime':
                    $schemaPropertie['type'] = 'string';
                    $schemaPropertie['pattern'] = '^(?=\\d)(?:(?:1[6-9]|[2-9]\\d)?\\d\\d([-.\\/])(?:1[012]|0?[1-9])\\1(?:31(?<!.(?:0[2469]|11))|(?:30|29)(?<!.02)|29(?=.0?2.(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00)))(?:\\x20|$))|(?:2[0-8]|1\\d|0?[1-9]))(?:(?=\\x20\\d)\\x20|$))?(((0?[1-9]|1[012])(:[0-5]\\d){0,2}(\\x20[AP]M))|([01]\\d|2[0-3])(:[0-5]\\d){1,2})?$';
                    break;
            }
        }
    }

    public function getErrorMessage(): array
    {
        return $this->errorMessage;
    }

    /**
     * @param $classObject
     *
     * @return false|string
     *
     * @throws \ReflectionException
     */
    public function getEntityAttribute($entityObject)
    {
        $documentClass = $this->getDocumentClass($entityObject);
        $entityInfo = $this->EWFCache->getItem('entity_attribute' . $documentClass);

        /* check if schema available in cache */
        if (!$entityInfo->isHit()) {
            $schemaProperties = [];
            $requiredField = [];
            $classObject = new \ReflectionClass($documentClass);

            foreach ($classObject->getMethods() as $method) {
                if (str_starts_with($method->getName(), 'set')) {
                    $methodAnnotation = $this->reader->getMethodAnnotation($method, "\EveryWorkflow\CoreBundle\Annotation\EWFDataTypes");
                    $schemaPropertie = [];
                    if (is_object($methodAnnotation)) {
                        $schemaPropertie['type'] = $this->getMethodAnnotationData($methodAnnotation, 'front_type');
                        $schemaPropertie['is_required'] = $this->getMethodAnnotationData($methodAnnotation, 'required');
                        $schemaPropertie['is_readonly'] = $this->getMethodAnnotationData($methodAnnotation, 'readonly');
                        $schemaPropertie['sort_order'] = $this->getMethodAnnotationData($methodAnnotation, 'sortOrder');
                        $schemaPropertie['is_system_define'] = true;
                        $schemaPropertie['entity_code'] = $entityObject->getEntityCode();
                        $schemaPropertie['status'] = 'enable';

                        if ($hasMongoFiled = $this->getMethodAnnotationData($methodAnnotation, 'mongofield')) {
                            $schemaPropertie['code'] = $hasMongoFiled;
                            $schemaPropertie['name'] = $this->sentence_case($hasMongoFiled);
                            $schemaProperties[] = $schemaPropertie;
                        } else {
                            $hasMongoFiled = $this->uncamelCase(ltrim($method->getName(), 'set'));
                            $schemaPropertie['code'] = $hasMongoFiled;
                            $schemaPropertie['name'] = $this->sentence_case($hasMongoFiled);
                            $schemaProperties[] = $schemaPropertie;
                        }

                        if ($required = $this->getMethodAnnotationData($methodAnnotation, 'required') && $hasMongoFiled) {
                            $requiredField[] = $hasMongoFiled;
                        }
                    }
                }
            }
            $this->logger->info(print_r($schemaProperties, true));
            /* save data to cache */
            $entityInfo->set($schemaProperties);
            $this->EWFCache->save($entityInfo);
        }

        return $entityInfo->get();
    }

    public function sentence_case(array | string $string): string
    {
        $intermediate = preg_replace(
            '/(?!^)([[:upper:]][[:lower:]]+)/',
            ' $0',
            $string
        );
        $titleStr = preg_replace(
            '/(?!^)([[:lower:]])([[:upper:]])/',
            '$1 $2',
            $intermediate
        );

        $titleStr = ucwords($titleStr);

        return trim(str_replace('_', ' ', $titleStr));
    }
}
