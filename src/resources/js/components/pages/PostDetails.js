import React, { useEffect, useState, Fragment } from 'react';
import axios from 'axios';
import { Container, makeStyles, Box } from '@material-ui/core';
import Spinner from '../common/Spinner';
import UserCard from '../users/UserCard';

const useStyles = makeStyles((theme) => ({
    root: {
        '& h1': {
            textAlign: 'center'
        }
    },
    image: {
        height: '30rem',
        backgroundColor: 'black',
        '& img': {
            objectFit: 'contain',
            width: '100%',
            height: '100%',
        }
    },
    contentArea: {
        marginTop: '3rem',
        display: 'flex',
        [theme.breakpoints.down('sm')]: {
            flexDirection: 'column',
            alignItems: 'center',
        },
        '& .content': {
            flexGrow: 1,
            margin: '1rem',
        },
        '& .userInfo': {
            flexShrink: 0,
            margin: '1rem',
        },
    },
    commentArea: {
        marginTop: '3rem',
    }
}));

const PostDetails = (props) => {
    const { id } = props.match.params;
    const classes = useStyles();
    const [loading, setLoading] = useState(false);
    const [postDetails, setDetails] = useState({
        title: '',
        content: '',
        user: {
            name: '',
            introduction: ''
        }
    })

    useEffect(() => {
        if (id) {
            setLoading(true);
            axios.get('/api/posts/' + id)
                .then(res => {
                    setDetails(res.data.data);
                    // dispatch(setLatestPostList(res.data.data));
                })
                .catch(error => {
                    console.log(error);
                })
                .finally(() => {
                    setLoading(false);
                })
        }
    }, [id])

    return (
        <div style={{ minHeight: '70vh' }}>
            {
                loading ? <Spinner cover={true} /> : null
            }
            {
                postDetails.main_image ? <Box className={classes.image}><img src={postDetails.main_image} /></Box> : null
            }
            <Container className={classes.root}>

                <Box mt={2} mb={4}>
                    <h1>{postDetails.title}</h1>
                </Box>
                <div className={classes.contentArea}>
                    <div className='content'>
                        {postDetails.content}
                    </div>
                    <div className='userInfo'>
                        <UserCard user={postDetails.user} />
                    </div>
                </div>
                <div className={classes.commentArea}>
                    <h3>コメント</h3>
                </div>
            </Container>
        </div>
    )
}

export default PostDetails
