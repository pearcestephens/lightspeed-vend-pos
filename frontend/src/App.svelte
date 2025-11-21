<script>
    import Header from '$components/Header.svelte';
    import Sidebar from '$components/Sidebar.svelte';
    import Footer from '$components/Footer.svelte';
</script>

<div class="app">
    <Header />
    <div class="container">
        <Sidebar />
        <main>
            <slot />
        </main>
    </div>
    <Footer />
</div>

<style>
    :global(body) {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Roboto', sans-serif;
        background: #f5f5f5;
    }

    .app {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .container {
        display: flex;
        flex: 1;
    }

    main {
        flex: 1;
        padding: 2rem;
        overflow-y: auto;
    }
</style>