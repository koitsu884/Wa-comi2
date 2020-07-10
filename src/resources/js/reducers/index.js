import { combineReducers } from "redux";
import authReducer from "./authReducer";
import homeReducer from "./homeReducer";
import commonReducer from "./commonReducer";
import postSearchReducer from "./postSearchReducer";
import formErrorReducer from "./formErrorReducer";
import userReducer from "./userReducer";


export default combineReducers({
    common: commonReducer,
    auth: authReducer,
    user: userReducer,
    home: homeReducer,
    postSearch: postSearchReducer,
    formError: formErrorReducer
});