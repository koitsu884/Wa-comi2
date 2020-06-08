import React from 'react';
import { makeStyles, IconButton } from '@material-ui/core';
import { Cancel } from '@material-ui/icons';
import NoImage from '../../../images/noImage.jpg';

const useStyles = makeStyles((theme) => ({
    imagePreview: {
        width: 300,
        height: 300,
        position: 'relative',
        margin: '1rem 0',
        '& img': {
            width: '100%',
            height: '100%',
            objectFit: 'contain'
        }
    },
    clearButton: {
        position: 'absolute',
        width: 30,
        height: 30,
        top: 2,
        right: 2
    }
}));

const ImagePreview = ({ previewUrl, handleCancel, enableCancelButton = false }) => {
    const classes = useStyles();

    return (
        <div className={classes.imagePreview}>
            {
                enableCancelButton
                    ? <IconButton aria-label="キャンセル" className={classes.clearButton} onClick={handleCancel}>
                        <Cancel fontSize="large" />
                    </IconButton>
                    : null
            }
            <img src={previewUrl ? previewUrl : NoImage} />
        </div>
    )
}

export default ImagePreview
