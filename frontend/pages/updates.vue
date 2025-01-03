<template>
    <div>Liveopdateringer</div>

    <div>
        <h2>Labels</h2>

        <Label type="date" :incident="incidents[0]" size="lg" />
        <Label type="date" :incident="incidents[1]" />
        <Label type="date" :incident="incidents[2]" size="sm" />
        <Label type="link" :incident="incidents[2]" />
    </div>

    <div style="height:50px"></div>

    <h1>Incidents</h1>

    <div>
        <!-- Loop through the incidents array -->
        <div v-for="incident in incidents" :key="incident.incident_id" class="incident-item"
            style="margin-bottom:20px;">
            <h2>{{ incident.title }}</h2>
            <p><strong>Message:</strong> {{ incident.message }}</p>
            <p><strong>Type:</strong> {{ incident.type }}</p>
            <p><strong>Status:</strong> {{ incident.status }}</p>
            <p><strong>Country:</strong> {{ incident.country }}</p>
            <p><strong>Expected Resolution:</strong> {{ incident.expected_resolved_at }}</p>
            <p><strong>Resolved At:</strong> {{ incident.resolved_at }}</p>
            <p v-if="incident.created_at"><strong>Created At:</strong> {{ incident.created_at }}</p>
            <p><strong>Updated At:</strong> {{ incident.updated_at }}</p>

            <!-- Displaying the carriers for each incident -->
            <div v-for="carrier in incident.carriers" :key="carrier.carrier_id" class="carrier-item">
                <h3>{{ carrier.title }}</h3>
                <p><strong>Type:</strong> {{ carrier.type }}</p>
                <p><strong>Status:</strong> {{ carrier.status }}</p>
                <p><strong>Description:</strong> {{ carrier.description }}</p>
                <p><strong>Peak Up Charge:</strong> {{ carrier.peak_up_charge }} DKK</p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { onMounted } from 'vue';
import { useIncidents } from '~/composables/useIncidents'; // Correct import

const { incidents, fetchIncidents } = useIncidents();

onMounted(() => {
    fetchIncidents();
});
</script>
