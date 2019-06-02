import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";
import dispatcher from '../../AppDispatcher';

export const serverActions = {
    upload
};

function upload(response, error) {
    dispatcher.dispatch({
        type: dropzoneConstants.UPLOAD_RESPONSE,
        response: response,
        error: error
    });
}