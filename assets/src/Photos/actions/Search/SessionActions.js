import dispatcher from '../../AppDispatcher';
import { searchConstants } from '../../../Shared/constants/SearchConstants';
import { request } from '../../../Shared/Api/SearchFilesApi';

export const sessionActions = {
    search
};

function search(data) {
    dispatcher.dispatch({
        type: searchConstants.SEARCH_REQUEST,
        data: data
    });

    request(data);
}
