import React from 'react';
import ReactDOM from 'react-dom';
import { Provider } from 'react-redux';
import store from './store';

import App from './components/App';
import { CssBaseline } from '@material-ui/core';

if (document.getElementById('root')) {
    ReactDOM.render(
        <Provider store={store}>
            {/* <CssBaseline /> */}
            <App />
        </Provider>
        , document.getElementById('root'));
}
