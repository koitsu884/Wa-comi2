import React from 'react'
import { Card, makeStyles, CardMedia, CardContent, Avatar, Box } from '@material-ui/core';
import NoImage from '../../../images/noImage.jpg';

const useStyles = makeStyles((theme) => ({
    root: {
        display: 'flex',
    },
    mainImage: {
        width: 150,
    },
    userInfo: {
        display: 'flex',
        alignItems: 'center',
    }
}));

const PostCard = ({ post }) => {
    const classes = useStyles();

    return (
        <Card className={classes.root}>
            <CardMedia
                className={classes.mainImage}
                image={post.main_image ? post.main_image.url : NoImage}
                title={post.title}
            />

            <CardContent>
                <h3>{post.title}</h3>
                <div className={classes.userInfo}>
                    {
                        post.user.avatar
                            ? <Avatar src={post.user.avatar.url} />
                            : <Avatar mr={2}>{post.user.name.charAt(0)}</Avatar>
                    }
                    <Box ml={2}>{post.user.name}</Box>
                </div>
            </CardContent>
        </Card>
    )
}

export default PostCard
