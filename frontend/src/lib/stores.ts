import { writable } from 'svelte/store';
import type { Writable } from 'svelte/store';

export const user: Writable<any> = writable(null);
export const loading: Writable<boolean> = writable(false);
export const error: Writable<string | null> = writable(null);
export const notifications: Writable<any[]> = writable([]);

export const setUser = (userData: any) => user.set(userData);
export const setLoading = (state: boolean) => loading.set(state);
export const setError = (err: string | null) => error.set(err);