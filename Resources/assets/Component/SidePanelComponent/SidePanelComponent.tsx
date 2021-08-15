/*
 * @copyright EveryWorkflow. All rights reserved.
 */

import React, { useState } from 'react';
import Drawer from 'antd/lib/drawer';
import {useResponsive} from "ahooks";

export const PANEL_SIZE_FULL = 'panel_full_size'; // default
export const PANEL_SIZE_HALF = 'panel_half_size'; // default
export const PANEL_SIZE_SMALL = 'panel_small_size';
export const PANEL_SIZE_MEDIUM = 'panel_medium_size';

export const PANEL_FROM_RIGHT = 'right'; // default
export const PANEL_FROM_LEFT = 'left';
export const PANEL_FROM_TOP = 'top';
export const PANEL_FROM_BOTTOM = 'bottom';

interface SidePanelComponentProps {
    children?: JSX.Element | JSX.Element[];
    title?: string;
    size?: string;
    fromDirection?: any;
    panelZIndex?: number;
    style?: any;
    bodyStyle?: any;
    onClose?: () => void;
    footer?: React.ReactNode;
    footerStyle?: React.CSSProperties;
}

const SidePanelComponent = ({
    children,
    title,
    size,
    fromDirection,
    panelZIndex,
    style,
    bodyStyle,
    onClose,
    footer,
    footerStyle,
}: SidePanelComponentProps) => {
    const responsive = useResponsive();
    const [visible, setVisible] = useState(true);

    const onComponentClose = () => {
        setVisible(false);
        if (onClose) {
            onClose();
        }
    };

    const getPanelSize = () => {
        if (!responsive.md) {
            return '84%';
        }
        switch (size) {
            case PANEL_SIZE_HALF: {
                return '50%';
            }
            case PANEL_SIZE_MEDIUM: {
                return '450px';
            }
            case PANEL_SIZE_SMALL: {
                return '250px';
            }
            default: {
                return 'calc(100% - 200px)';
            }
        }
    };

    return (
        <>
            <Drawer
                style={style}
                bodyStyle={bodyStyle}
                title={title}
                placement={fromDirection ?? PANEL_FROM_RIGHT}
                onClose={onComponentClose}
                visible={visible}
                width={getPanelSize()}
                zIndex={panelZIndex ?? 1001}
                footer={footer}
                footerStyle={footerStyle}
            >
                {children}
            </Drawer>
        </>
    );
};

export default SidePanelComponent;
