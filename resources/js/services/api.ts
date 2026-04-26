import axios, {AxiosRequestConfig} from "axios";

export const getRequest = (url: string, params?: object, config?: AxiosRequestConfig) => {
    return axios.get(url, { ...config, params });
};

export const postRequest = (url: string, params?: object, config?: AxiosRequestConfig) => {
    return axios.post(url, { ...config, params });
};

export const putRequest = (url: string, params?: object, config?: AxiosRequestConfig) => {
    return axios.put(url, { ...config, params });
};

export const patchRequest = (url: string, params?: object, config?: AxiosRequestConfig) => {
    return axios.patch(url, { ...config, params });
};

export const deleteRequest = (url: string, params?: object, config?: AxiosRequestConfig) => {
    return axios.delete(url, { ...config, params });
};
