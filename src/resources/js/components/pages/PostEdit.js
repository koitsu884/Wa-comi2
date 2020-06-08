import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Container, Button, Box, makeStyles } from '@material-ui/core';
import { FormContext, useForm } from 'react-hook-form';
import history from '../../history';
import Alert from '../../utils/alert';
import { TextField } from '../form/TextField';
import TextAreaField from '../form/TextAreaField';
import Spinner from '../common/Spinner';
import SelectImageField from '../form/SelectImageField';
import ResponsiveFlexBox from '../layouts/ResponsiveFlexBox';
import { resizeFile } from '../../utils/imageManager';
import FormErrors from '../common/FormErrors';
import { SET_ERRORS } from '../../actions/types';

const POST_IMAGE_SIZE_LIMIT = 800;

const PostEdit = (props) => {
    const id = props.match.params.id;
    const methods = useForm();
    const dispatch = useDispatch();
    const currentUser = useSelector(state => state.auth.user);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (id) {
            setLoading(true);
            axios.get('/api/posts/' + id)
                .then(res => {
                    let postData = res.data.data;

                    if (postData.user_id !== currentUser.id) {
                        history.push('/');
                        Alert.error("投稿を編集する権限がありません");
                        return;
                    }
                    setDetails(postData);
                })
                .catch(error => {
                    // Alert.error("投稿データの取得に失敗しました");
                    console.log(error);
                })
                .finally(() => {
                    setLoading(false);
                })
        }
    }, [id])

    const onSubmit = async submitedData => {
        if (!currentUser) {
            console.log("Current user must be set");
            return;
        }

        setLoading(true);

        let fd = new FormData();

        for (var dataKey in submitedData) {
            let data = submitedData[dataKey];
            switch (dataKey) {
                case "main_image":
                    if (data) {
                        let resizedFile = await resizeFile(data, POST_IMAGE_SIZE_LIMIT, data.name);
                        fd.append('main_image', resizedFile, resizedFile.name);
                    }
                    break;

                default:
                    fd.append(dataKey, data ? data : '');
            }
        }

        let url = `/api/users/${currentUser.id}/posts/`;
        // let result;

        try {
            if (id) {
                await axios.put(url, fd, {
                    headers: { 'content-type': 'multipart/form-data' }
                });
                Alert.success("更新しました");
            }
            else {
                await axios.post(url, fd, {
                    headers: { 'content-type': 'multipart/form-data' }
                });
                Alert.success("投稿しました");
            }
            setLoading(false);
        }
        catch (error) {
            let formErrors = error.response.data.errors;
            if (formErrors) {
                // console.log(formErrors);
                dispatch({
                    type: SET_ERRORS,
                    payload: formErrors
                })
            }
            setLoading(false);
            return;
        }

        history.push('/post');
    }


    return (
        <Container style={{ minHeight: '80vh' }}>
            {
                loading ? <Spinner cover={true} /> : null
            }
            <h1>Post Edit</h1>
            <Box>
                <FormContext {...methods}>
                    <form onSubmit={methods.handleSubmit(onSubmit)}>
                        <ResponsiveFlexBox breakPoint={'sm'}  >
                            <Box p={2} flexGrow={1}>
                                <TextField
                                    fullWidth
                                    inputRef={methods.register({ required: true, maxLength: 200 })}
                                    required
                                    id="title"
                                    label="タイトル"
                                    name="title"
                                    type="text"
                                    margin="normal"
                                />
                                <TextAreaField
                                    fullWidth
                                    inputRef={methods.register({ required: true, maxLength: 5000 })}
                                    required
                                    id="content"
                                    label="投稿内容"
                                    name="content"
                                    margin="normal"
                                    rows={10}
                                />
                            </Box>
                            <Box p={2}>
                                <h3>メイン画像</h3>
                                <SelectImageField
                                    inputRef={methods.register()}
                                    name="main_image"
                                />
                            </Box>
                        </ResponsiveFlexBox>
                        <FormErrors />
                        <Button
                            type="submit"
                            margin="auto"
                            variant="contained"
                            color="primary"
                        >
                            {id ? "編集する" : "投稿する"}
                        </Button>
                    </form>
                </FormContext>
            </Box>
        </Container>
    )
}

export default PostEdit
