<script lang="ts">
    export let title: string = '';
    export let data: any = null;
</script>

<div class="component-metricscard">
    {#if title}
        <h3>{title}</h3>
    {/if}

    <!-- Component content here -->
    <slot />
</div>

<style>
    .component-metricscard {
        background: white;
        border-radius: 8px;
        padding: 1rem;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    h3 {
        margin: 0 0 1rem 0;
        font-size: 1.1rem;
    }
</style>