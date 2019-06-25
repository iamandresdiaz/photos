import axios from "axios";
import { serverActions } from "../../Photos/actions/Search/ServerActions";
import { apiEndpoints } from "../constants/SearchConstants";

export function request(raw) {
    const url = apiEndpoints.SEARCH;
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
            serverActions.search(response.data, null)
        })
        .catch((error) => {
            serverActions.search(null, error)
        });
}