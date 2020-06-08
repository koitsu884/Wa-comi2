import React from 'react';
import { FormControl } from '@material-ui/core';
import { FieldError } from './FieldError';
import { useFormContext } from 'react-hook-form';

const Field = ({
    children,
    name,
    info,
    customErrorMessage,
    ...props
}) => {
    const { errors } = useFormContext();

    return (
        <FormControl 
            error = { errors[name] ? true : false}
            {...props}
        >
            {children}
            {errors[name] ? <FieldError error={errors[name]} customErrorMessage={customErrorMessage} /> : null}
            {info ? <FormHelperText error={false}>{info}</FormHelperText> : null}
        </FormControl>
    )
}

export default Field
