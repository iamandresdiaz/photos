import axios from "axios";
import { serverActions } from "../../Photos/actions/Search/ServerActions";
import { apiEndpoints } from "../constants/SearchConstants";

export function request(text) {
    const url = apiEndpoints.SEARCH;
    axios.get(
        `${url}${text}`
    )
        .then((response) => {
            serverActions.search(response.data, null);
        })
        .catch((error) => {
            serverActions.search(null, error);
        });
}