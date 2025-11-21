<script>
    // Root page - will redirect to dashboard
    import { goto } from '$app/navigation';
    import { onMount } from 'svelte';
    
    onMount(() => {
        goto('/dashboard');
    });
</script>

<div>
    <h1>Loading...</h1>
</div>
