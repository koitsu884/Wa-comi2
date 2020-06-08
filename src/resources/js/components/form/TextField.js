import React from 'react'
import Field from './Field';
import { TextField as MiTextField } from '@material-ui/core';

export const TextField = ({
    id,
    name,
    type,
    variant,
    margin,
    label,
    autoComplete,
    fullWidth,
    inputRef,
    required,
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
            {/* {label ? <InputLabel>{label}</InputLabel> : null}
            <Input
                inputRef={inputRef}
                // required={required}
                id={id}
                autoComplete={autoComplete}
                name={name}
                type={type}
                variant={variant}
                {...props}
            /> */}
            <MiTextField
                label={label ? label : null}
                inputRef={inputRef}
                id={id}
                autoComplete={autoComplete}
                name={name}
                type={type}
                variant={variant}
                required={required}
                {...rest}
            />
        </Field>
    )
}
