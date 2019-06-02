import axios from "axios";
import { serverActions } from "../../Photos/actions/Dropzone/ServerActions";
import { apiEndpoints } from "../constants/DropzoneConstants";

export function uploadRequest(data) {
    const url = apiEndpoints.UPLOAD;
    axios.post(
        url,
        data,
        {
            headers: {
                'Content-Type': 'application/json',
            }
        }
        )
        .then((response) => {
            serverActions.upload(response, null)
        })
        .catch((error) => {
            serverActions.upload(null, error)
        });
}