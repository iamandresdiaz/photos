import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";
import dispatcher from '../../AppDispatcher';

export const serverActions = {
    upload
};

function upload(status, error) {
    dispatcher.dispatch({
        type: dropzoneConstants.UPLOAD_RESPONSE,
        status: status,
        error: error
    });
}