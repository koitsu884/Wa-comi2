import { SET_AVATAR, SET_MYPOSTS, DELETE_USER_POST } from "./types";
// import axios from 'axios';
import client from '../utils/client';
import Alert from '../utils/alert';
import { setLoading } from './commonActions';

const baseUrl = '/api/users/';

const setAvatar = (avatar) => dispatch => {
    dispatch({
        type: SET_AVATAR,
        payload: avatar
    });
}

const setMyPosts = (postList) => dispatch => {
    dispatch({
        type: SET_MYPOSTS,
        payload: postList
    });
}

const deleteUserPost = (postId) => dispatch => {
    dispatch({
        type: DELETE_USER_POST,
        payload: postId
    });
}

export const getAvatar = (userId) => dispatch => {
    client.get(`${userId}/avatar`, { baseURL: baseUrl })
        .then(res => {
            dispatch(setAvatar(res.data.data));
        })
        .catch(error => {
            console.log(error.response.data);
        })
}

export const addAvatar = (userId, fd) => dispatch => {
    dispatch(setLoading(true));
    client.post(`${userId}/avatar`, fd, { baseURL: baseUrl })
        .then(res => {
            dispatch(setAvatar(res.data.data));
        })
        .catch(error => {
            Alert.error(error.response.data);
            console.log(error.response.data);
        })
        .finally(() => {
            dispatch(setLoading(false));
        })
}

export const deleteAvatar = (userId) => dispatch => {
    dispatch(setLoading(true));
    client.delete(`${userId}/avatar`, { baseURL: baseUrl })
        .then(res => {
            dispatch(setAvatar(null));
        })
        .catch(error => {
            Alert.error(error.response.data);
            console.log(error.response.data);
        })
        .finally(() => {
            dispatch(setLoading(false));
        })
}

export const getMyPosts = (userId) => dispatch => {
    client.get(`${userId}/posts`, { baseURL: baseUrl })
        .then(res => {
            dispatch(setMyPosts(res.data.data))
        })
        .catch(error => {
            console.log(error.response.data);
        })
}

export const deletePost = (postId) => dispatch => {
    dispatch(setLoading(true));
    client.delete(`/posts/${postId}`)
        .then(res => {
            dispatch(deleteUserPost(postId));
            Alert.success("削除しました");
        })
        .catch(error => {
            console.log(error);
            Alert.error(error.response.data);
            console.log(error.response.data);
        })
        .finally(() => {
            dispatch(setLoading(false));
        })
}
