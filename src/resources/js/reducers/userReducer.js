import { SET_AVATAR, SET_MYPOSTS, DELETE_USER_POST } from "../actions/types";

const INITIAL_STATE = {
    avatar: null,
    myPosts: [],
}

export default (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case SET_AVATAR:
            return {
                ...state,
                avatar: action.payload
            }
        case SET_MYPOSTS:
            return {
                ...state,
                myPosts: action.payload
            }
        case DELETE_USER_POST:
            return {
                ...state,
                myPosts: state.myPosts.filter(post => post.id !== action.payload)
            }
        default:
            return state;
    }
}
