import React from 'react';
import { CircularProgress, makeStyles } from '@material-ui/core';

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
        height: '100%',
        margin: 'auto',
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'center'
    },
    cover: {
        zIndex: 10,
        backgroundColor: 'rgba(0, 0, 0, .2)',
        top: 0,
        left: 0,
        position: 'absolute',
    }
}));

export default ({ cover }) => {
    const classes = useStyles();
    return (
        // <div className={`spinner${cover ? " cover" : ""}`}><div className="spinner__inner"></div></div>
        <div className={`${classes.root} ${cover ? classes.cover : ''}`}><CircularProgress /></div>
    )
}
