import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";
import dispatcher from '../../AppDispatcher';
import { uploadRequest } from "../../../Shared/Api/Api";

export const sessionActions = {
    upload
};

function upload(data) {
    dispatcher.dispatch({
        type: dropzoneConstants.UPLOAD_REQUEST,
        data: data
    });

    uploadRequest(data);
}
