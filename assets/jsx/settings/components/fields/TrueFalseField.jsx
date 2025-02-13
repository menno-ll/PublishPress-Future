/*
 * Copyright (c) 2023. PublishPress, All rights reserved.
 */

import {Fragment} from "react";

const TrueFalseField = function (props) {
    const onChange = (e) => {
        if (props.onChange) {
            props.onChange(
                e.target.value === props.trueValue && jQuery(e.target).is(':checked')
            );
            // Check only the true radio... using the field name? or directly the ID
        }
    };

    return (
        <Fragment>
            <input
                type="radio"
                name={props.name}
                id={props.name + '-true'}
                value={props.trueValue}
                defaultChecked={props.selected}
                onChange={onChange}
            />

            <label htmlFor={props.name + '-true'}>{props.trueLabel}</label>
            &nbsp;&nbsp;
            <input
                type="radio"
                name={props.name}
                defaultChecked={!props.selected}
                id={props.name + '-false'}
                value={props.falseValue}
                onChange={onChange}
            />
            <label
                htmlFor={props.name + '-false'}>{props.falseLabel}</label>

            <p className="description">{props.description}</p>
        </Fragment>
    )
}

export default TrueFalseField;
