import dispatcher from '../../AppDispatcher';
import {searchConstants} from "../../../Shared/constants/SearchConstants";

export const serverActions = {
    search
};

function search(data, error) {
    dispatcher.dispatch({
        type: searchConstants.SEARCH_RESPONSE,
        data: data,
        error: error
    });
}