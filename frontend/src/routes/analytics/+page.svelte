<script>
    import MetricsCard from '$components/MetricsCard.svelte';
    import ChartWidget from '$components/ChartWidget.svelte';
</script>

<div class="page-analytics">
    <h1>analytics</h1>

    <div class="metrics">
        <MetricsCard title="Total Items" value="1,234" trend="+12%" />
        <MetricsCard title="Active" value="856" trend="+5%" />
        <MetricsCard title="Success Rate" value="94.2%" trend="+3.1%" />
    </div>

    <div class="charts">
        <ChartWidget title="Activity Over Time" />
        <ChartWidget title="Distribution" />
    </div>
</div>

<style>
    .page-analytics {
        padding: 1rem;
    }

    h1 {
        margin-top: 0;
    }

    .metrics {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1rem;
        margin: 2rem 0;
    }

    .charts {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 1rem;
    }
</style>