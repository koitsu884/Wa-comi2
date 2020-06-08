import { SET_CURRENT_USER } from "./types";
// import axios from 'axios';
import client from '../utils/client';
import history from '../history';
import Alert from '../utils/alert';
import { kTokenExpire } from "../constants/localStorage";

const baseUrl = '/api/auth/';

const setCurrentUser = (user) => dispatch => {
    dispatch({
        type: SET_CURRENT_USER,
        payload: user
    });
}

export const register = fd => dispatch => {
    client.post('register', fd, { baseURL: baseUrl }).then(res => {
        console.log(res);
        dispatch(signin(fd));
    }).catch(error => {
        console.log(error.response);
        let { message, errors } = error.response.data;

        if (errors.email) {
            Alert.error(errors.email);
        }
    })
}

export const signin = fd => dispatch => {
    client.post('login', fd, { baseURL: baseUrl }).then(res => {
        dispatch(setCurrentUser(res.data.user));
        localStorage.setItem(kTokenExpire, Date.now() + res.data.expires_in * 1000);
        history.push('/');
    }).catch(error => {
        console.log(error);
    })
}

export const getCurrentUser = () => dispatch => {
    client.get('me', { baseURL: baseUrl })
        .then(res => {
            console.log(res);
            dispatch(setCurrentUser(res.data.data));
        })
        .catch(error => {
            console.log(error);
        })
}

export const logout = () => dispatch => {
    client.get('logout', { baseURL: baseUrl })
        .then(res => {
            dispatch(setCurrentUser(null));
            localStorage.removeItem(kTokenExpire);
            history.push('/');
            Alert.success("ログアウトしました");
        })
        .catch(error => {
            console.log(error);
        })
}