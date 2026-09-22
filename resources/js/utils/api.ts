import axios, { AxiosRequestConfig } from "axios";

export const getRequest = <T = unknown>(url: string, params?: object, config?: AxiosRequestConfig) =>
    axios.get<T>(url, { ...config, params });

export const deleteRequest = <T = unknown>(url: string, params?: object, config?: AxiosRequestConfig) =>
    axios.delete<T>(url, { ...config, params });

export const postRequest = <T = unknown>(url: string, data?: object, config?: AxiosRequestConfig) =>
    axios.post<T>(url, data, config);

export const putRequest = <T = unknown>(url: string, data?: object, config?: AxiosRequestConfig) =>
    axios.put<T>(url, data, config);

export const patchRequest = <T = unknown>(url: string, data?: object, config?: AxiosRequestConfig) =>
    axios.patch<T>(url, data, config);
