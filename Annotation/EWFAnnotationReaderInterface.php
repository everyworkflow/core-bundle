<?php
namespace EveryWorkflow\CoreBundle\Annotation;



interface EWFAnnotationReaderInterface {


    /**
     * @param $className
     * @return string
     */
    public function getDocumentClass(object $classObject): string;

    public function validateData(array $data, object $classObject ): bool;

    public function getErrorMessage(): array;

}