import { SET_LOADING, SET_AREA_LIST, SET_POST_CATEGORIES, SET_GROUP_CATEGORIES } from "./types";
import axios from 'axios';

export const setLoading = (flag) => dispatch => {
    dispatch({
        type: SET_LOADING,
        payload: flag
    });
}

const setAreaList = (areaList) => dispatch => {
    dispatch({
        type: SET_AREA_LIST,
        payload: areaList
    });
}

const setPostCategories = (postCategories) => dispatch => {
    dispatch({
        type: SET_POST_CATEGORIES,
        payload: postCategories
    });
}

const setGroupCategories = (groupCategories) => dispatch => {
    dispatch({
        type: SET_GROUP_CATEGORIES,
        payload: groupCategories
    });
}

export const getAreaList = () => dispatch => {
    axios.get('/api/areas')
        .then(res => {
            dispatch(setAreaList(res.data.data));
        })
        .catch(error => {
            console.log(error);
        })
}

export const getPostCategories = () => dispatch => {
    axios.get('/api/postcategories')
        .then(res => {
            dispatch(setPostCategories(res.data.data));
        })
        .catch(error => {
            console.log(error);
        })
}

export const getGroupCategories = () => dispatch => {
    axios.get('/api/groupcategories')
        .then(res => {
            dispatch(setGroupCategories(res.data.data));
        })
        .catch(error => {
            console.log(error);
        })
}
