import { SET_LATEST_GROUP_LIST, SET_LATEST_POST_LIST } from "./types";
import axios from 'axios';

// const baseUrl = '/api/';

const setLatestGroupList = (groupList) => dispatch => {
    dispatch({
        type: SET_LATEST_GROUP_LIST,
        payload: groupList
    });
}

const setLatestPostList = (postList) => dispatch => {
    dispatch({
        type: SET_LATEST_POST_LIST,
        payload: postList
    });
}

export const getLatestPostList = () => dispatch => {
    axios.get('/api/posts?per_page=6')
        .then(res => {
            dispatch(setLatestPostList(res.data.data));
        })
        .catch(error => {
            console.log(error);
        })
}

export const getLatestGroupList = () => dispatch => {
    axios.get('/api/groups?per_page=6')
        .then(res => {
            console.log(res.data);
            dispatch(setLatestGroupList(res.data.data));
        })
        .catch(error => {
            console.log(error);
        })
}