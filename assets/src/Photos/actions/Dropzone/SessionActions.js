import { dropzoneConstants } from "../../../Shared/constants/DropzoneConstants";
import dispatcher from '../../AppDispatcher';
import { request } from "../../../Shared/Api/AddFileApi";

export const sessionActions = {
    upload
};

function upload(data) {
    dispatcher.dispatch({
        type: dropzoneConstants.UPLOAD_REQUEST,
        data: data
    });

    request(data);
}
