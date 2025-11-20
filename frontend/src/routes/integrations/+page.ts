export const prerender = true;

export async function load({ fetch }) {
    try {
        const response = await fetch(`/api/v1/{{page}}`);
        const data = await response.json();

        return {
            items: data.data,
        };
    } catch (error) {
        console.error('Failed to load data:', error);
        return {
            items: [],
        };
    }
}