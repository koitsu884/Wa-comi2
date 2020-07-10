import React, { useEffect, useState } from 'react';
import { useSelector, useDispatch } from 'react-redux';
import { Container, Button, Box } from '@material-ui/core';
import { FormContext, useForm } from 'react-hook-form';
import { getMyPosts } from '../../actions/userActions';
import history from '../../history';
import Alert from '../../utils/alert';
import { TextField } from '../form/TextField';
import TextAreaField from '../form/TextAreaField';
import Spinner from '../common/Spinner';
import ResponsiveFlexBox from '../layouts/ResponsiveFlexBox';
import { resizeFile } from '../../utils/imageManager';
import FormErrors from '../common/FormErrors';
import { SET_ERRORS } from '../../actions/types';
import MultipleImageSelector from '../common/MultipleImageSelector';
import ModalMessage from '../common/ModalMessage';

const POST_IMAGE_SIZE_LIMIT = 800;

const PostEdit = (props) => {
    const id = props.match.params.id;
    const methods = useForm();
    const dispatch = useDispatch();
    const currentUser = useSelector(state => state.auth.user);
    const [loading, setLoading] = useState(false);
    const [modalMessage, setModalMessage] = useState(null);
    const [selectedFiles, setFiles] = useState([]);

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

    const handleImageSelect = selectedFiles => {
        setFiles(selectedFiles);
    }

    const updatePost = async (url, fd) => {
        await axios.put(url, fd, {
            headers: { 'content-type': 'multipart/form-data' }
        });
        Alert.success("更新しました");
    }

    const uploadImages = async (url, files) => {
        for (var file of files) {
            let fd = new FormData();
            let resizedFile;
            try {
                resizedFile = await resizeFile(file, POST_IMAGE_SIZE_LIMIT, file.name);
                fd.append('image', resizedFile, resizedFile.name);
                await axios.post(url, fd);
            }
            catch (error) {
                console.log(error);
            }
        }
    }

    const addNewPost = async (url, fd) => {
        var result = await axios.post(url, fd, {
            headers: { 'content-type': 'multipart/form-data' }
        });

        if (selectedFiles.length > 0) {
            setModalMessage("画像をアップロード中です");
            var newPostId = result.data.data.id;
            let imageUploadUrl = `/api/posts/${newPostId}/images`;
            //File upload
            await uploadImages(imageUploadUrl, selectedFiles);
        }

        Alert.success("投稿しました");
        dispatch(getMyPosts(currentUser.id));
    }

    const onSubmit = async submitedData => {
        if (!currentUser) {
            console.log("Current user must be set");
            return;
        }

        setLoading(true);
        setModalMessage("投稿内容をアップロード中です");

        let fd = new FormData();
        let url = `/api/posts/`;

        for (var dataKey in submitedData) {
            let data = submitedData[dataKey];
            switch (dataKey) {
                default:
                    fd.append(dataKey, data ? data : '');
            }
        }

        try {
            id ? await updatePost(url, fd) : await addNewPost(url, fd);

            setLoading(false);
            setModalMessage(null);
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
            setModalMessage(null);
            return;
        }

        history.push('/post');
    }


    return (
        <Container style={{ minHeight: '80vh' }}>
            {
                loading ? <Spinner cover={true} /> : null
            }
            <ModalMessage
                open={modalMessage !== null}
                message={modalMessage}
            />

            <h1>Post Edit</h1>
            <Box>
                <FormContext {...methods}>
                    <form onSubmit={methods.handleSubmit(onSubmit)}>
                        <ResponsiveFlexBox breakPoint={'sm'}  >
                            <Box p={2} flexGrow={1} minWidth={600}>
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
                            <Box p={2} minWidth={400}>
                                {
                                    id ?
                                        null :
                                        <MultipleImageSelector onImagesSelected={handleImageSelect} maxNum={5} />
                                }
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
