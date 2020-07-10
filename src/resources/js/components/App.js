import React, { useEffect } from 'react';
import { Router, Route, Switch } from 'react-router-dom';
import { useDispatch } from 'react-redux';
import TopBar from './layouts/TopBar';
import { ThemeProvider } from '@material-ui/styles';
import { createMuiTheme } from '@material-ui/core/styles';
import { teal, amber, white } from '@material-ui/core/colors';

import { getAreaList, getPostCategories, getGroupCategories } from '../actions/commonActions';
import { getCurrentUser } from '../actions/authActions';
import history from '../history';
import { Home } from './pages/Home';
import { Register } from './pages/Register';
import { Login } from './pages/Login';
import { Hidden, CssBaseline } from '@material-ui/core';
import BackToTop from './layouts/BackToTop';
import Post from './pages/Post';
import Group from './pages/Group';
import Event from './pages/Event';
import BottomNav from './layouts/BottomNav';
import Footer from './layouts/Footer';
import PostDetails from './pages/PostDetails';
import NotFound from './pages/NotFound';
import PostEdit from './pages/PostEdit';
import PrivateRoute from './PrivateRoute';
import MyAccount from './pages/MyAccount';
import MyPost from './pages/MyPost';

const theme = createMuiTheme({
    typography: {
        // htmlFontSize: 10,

        // '@media (max-width:960px)': {
        //     htmlFontSize: 7,
        // },
        // '@media (max-width:600px)': {
        //     htmlFontSize: 5,
        // },

        fontSize: 12,

        fontFamily: [
            '"M PLUS Rounded 1c"',
            '"Kosugi Maru"',
            'Roboto',
            'sans-serif',
        ].join(','),
    },

    palette: {
        primary: {
            main: teal[300],
            contrastText: '#fff'
        },
        secondary: amber
    },
    overrides: {
        MuiCssBaseline: {
            '@global': {
                '@font-face': '"M PLUS Rounded 1c"',
            },
        },
        MuiOutlinedInput: {
            root: {
                backgroundColor: '#fff',
                '&:focus': {
                    backgroundColor: '#fff',
                }
            },
            input: {
                padding: '.5rem 1rem',
            },
        },
        MuiInputLabel: {
            outlined: {
                transform: 'translate(14px, 10px) scale(1)'
            }
        }
    }
});

const App = () => {
    const dispatch = useDispatch();

    useEffect(() => {
        dispatch(getAreaList());
        dispatch(getGroupCategories());
        dispatch(getPostCategories());
        dispatch(getCurrentUser());
    }, [
        dispatch,
        getAreaList,
        getGroupCategories,
        getPostCategories,
        getCurrentUser,
    ])

    return (
        <ThemeProvider theme={theme}>
            <CssBaseline />
            <Router history={history}>
                <Hidden xsDown>
                    <TopBar />
                </Hidden>
                <Switch>
                    <Route path="/" exact component={Home} />
                    <Route path="/register" exact component={Register} />
                    <Route path="/login" exact component={Login} />
                    <PrivateRoute path="/mypage/account" exact component={MyAccount} />
                    <PrivateRoute path="/mypage/post" exact component={MyPost} />
                    <Route path="/post" exact component={Post} />
                    <PrivateRoute path="/post/edit/:id" exact component={PostEdit} />
                    <PrivateRoute path="/post/edit" exact component={PostEdit} />
                    <Route path="/post/:id" exact component={PostDetails} />
                    <Route path="/group" exact component={Group} />
                    <Route path="/event" exact component={Event} />
                    <Route path="/*" component={NotFound} />
                </Switch>
                <Hidden xsDown>
                    <BackToTop />
                </Hidden>
                <Hidden smUp>
                    <BottomNav />
                </Hidden>
                <Footer />
            </Router>
        </ThemeProvider>
    )
}

export default App
