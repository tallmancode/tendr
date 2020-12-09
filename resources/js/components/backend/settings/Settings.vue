<template>
    <div class="card full">
        <div class="card__body">
             <tabs :options="{ useUrlFragment: false, defaultTabHash : activeTab }">
                <tab name="General">
                    <General></General>
                </tab>
                <tab name="WHatver">
                    adasdasdasdasd
                </tab>
            </tabs>
        </div>
    </div>
</template>

<script>
    import General from './tabs/General'

    export default {
        name: 'Settings',
        components: {
            General,
        },
        data() {
            return {
                 activeTab: '#contact-information',
            };
        }
    }
</script>


