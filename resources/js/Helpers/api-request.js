import axios from 'axios';

export function useApiRequest() {
    const fetchData = async (route, params) => {
        try {
            const response = await axios.get(route, { params });
            return response.data;
        } catch (error) {
            console.error('Error fetching data:', error);
            throw error;
        }
    };
    return {
        fetchData,
    };
}