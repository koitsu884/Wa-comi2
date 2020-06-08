import React, { useState, useEffect } from 'react'
import { FormContext, useForm } from 'react-hook-form';
import { useSelector, useDispatch } from 'react-redux';
import { Box, Button } from '@material-ui/core';

import { getCurrentUser } from '../../../actions/authActions';
import client from '../../../utils/client';
import Alert from '../../../utils/alert';
import { TextField } from '../../form/TextField';
import TextAreaField from '../../form/TextAreaField';
import ResponsiveFlexBox from '../../layouts/ResponsiveFlexBox';
import SelectImageField from '../../form/SelectImageField';
import Spinner from '../../common/Spinner';
import FormErrors from '../../common/FormErrors';
import { resizeFile } from '../../../utils/imageManager';

const AVATAR_IMAGE_SIZE_LIMIT = 400;

const ProfileEdit = () => {
    const methods = useForm();
    const dispatch = useDispatch();
    const currentUser = useSelector(state => state.auth.user);
    const [loading, setLoading] = useState(false);

    useEffect(() => {
        if (currentUser) {
            methods.setValue('name', currentUser.name);
            methods.setValue('introduction', currentUser.introduction);
            methods.setValue('twitter', currentUser.twitter);
            methods.setValue('facebook', currentUser.facebook);
            methods.setValue('instagram', currentUser.instagram);
        }
    }, [currentUser, methods])

    const handleDeleteAvatar = () => {
        Alert.confirm("現在設定されている画像を削除しますか？")
            .then((result) => {
                if (result.value) {
                    let url = `users/${currentUser.id}/image`;
                    setLoading(true);
                    client.delete(url)
                        .then(() => {
                            dispatch(getCurrentUser());
                            Alert.success("削除しました");
                        })
                        .catch(error => {
                            Alert.error(error);
                        })
                        .finally(() => {
                            setLoading(false);
                        })
                }
            })
    }

    const onSubmit = async submitedData => {
        setLoading(true);

        let fd = new FormData();
        fd.append('_method', 'PATCH');

        for (var dataKey in submitedData) {
            let data = submitedData[dataKey];
            switch (dataKey) {
                case "avatar":
                    if (data) {
                        let resizedFile = await resizeFile(data, AVATAR_IMAGE_SIZE_LIMIT, data.name);
                        fd.append('avatar', resizedFile, resizedFile.name);
                    }
                    break;

                default:
                    fd.append(dataKey, data ? data : ''); //TODO: in some reason, 'NULL' is set for empty field...?
            }
        }

        let url = `users/${currentUser.id}`;
        // let result;

        try {
            await client.post(url, fd, {
                headers: { 'content-type': 'multipart/form-data' }
            });
            dispatch(getCurrentUser());
            Alert.success("更新しました");

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

        // history.push('/mypage');
    }

    return (
        <Box>
            {
                loading ? <Spinner cover={true} /> : null
            }
            <h2>プロフィール編集</h2>
            <FormContext {...methods}>
                <form onSubmit={methods.handleSubmit(onSubmit)}>
                    <ResponsiveFlexBox breakPoint={'sm'} >
                        <Box flexGrow={1}>
                            <TextField
                                fullWidth
                                variant="outlined"
                                inputRef={methods.register({ required: true, maxLength: 100 })}
                                required
                                id="name"
                                label="表示名"
                                name="name"
                                type="text"
                                margin="normal"
                            />
                            <TextAreaField
                                fullWidth
                                variant="outlined"
                                inputRef={methods.register({ maxLength: 5000 })}
                                id="introduction"
                                label="自己紹介文"
                                name="introduction"
                                margin="normal"
                                rows={10}
                            />

                            <TextField
                                fullWidth
                                variant="outlined"
                                inputRef={methods.register({ maxLength: 100 })}
                                id="twitter"
                                label="Twitter アドレス"
                                name="twitter"
                                type="url"
                                margin="normal"
                            />
                            <TextField
                                fullWidth
                                variant="outlined"
                                inputRef={methods.register({ maxLength: 100 })}
                                id="facebook"
                                label="Facebook アドレス"
                                name="facebook"
                                type="url"
                                margin="normal"
                            />
                            <TextField
                                fullWidth
                                variant="outlined"
                                inputRef={methods.register({ maxLength: 100 })}
                                id="instagram"
                                name="instagram"
                                type="url"
                                margin="normal"
                            />
                        </Box>
                        <Box p={2}>
                            <h3>メイン画像</h3>
                            <SelectImageField
                                inputRef={methods.register()}
                                name="avatar"
                                initialImageUrl={currentUser.avatar}
                                onDelete={handleDeleteAvatar}
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
                        変更を保存する
                        </Button>
                </form>
            </FormContext>
        </Box>
    )
}

export default ProfileEdit
