import axios from "axios";
import { serverActions } from "../../Photos/actions/Dropzone/ServerActions";
import { apiEndpoints } from "../constants/DropzoneConstants";

export function request(raw) {
    const url = apiEndpoints.UPLOAD;

    axios.post(
        url,
        raw,
        {
            headers: {
                'Content-Type': 'application/json',
            }
        }
        )
        .then((response) => {
            serverActions.upload(response.status, null)
        })
        .catch((error) => {
            serverActions.upload(null, error)
        });
}