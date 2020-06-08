import React from 'react'
import { TextField, InputLabel } from '@material-ui/core';
import Field from './Field';

const TextAreaField = ({
    id,
    name,
    variant,
    margin,
    label,
    autoComplete,
    fullWidth,
    inputRef,
    required,
    rows = 5,
    customErrorMessage,
    ...rest
}) => {
    return (
        <Field
            fullWidth={fullWidth}
            margin={margin}
            name={name}
            customErrorMessage={customErrorMessage}
        >
            <TextField
                label={label ? label : null}
                multiline
                rows={rows}
                inputRef={inputRef}
                name={name}
                variant={variant}
                required={required}
                {...rest}
            />
            {/* <Input
                inputRef={inputRef}
                required={required}
                id={id}
                autoComplete={autoComplete}
                name={name}
                type={type}
                variant={variant}
                {...props}
            /> */}
        </Field>
    )
}

export default TextAreaField
