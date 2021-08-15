/*
 * @copyright EveryWorkflow. All rights reserved.
 */

interface ButtonInterface {
    label?: string;
    content?: string;
    url?: string;
    css_class?: string;
    onClick?: () => void;
}

export default ButtonInterface;
