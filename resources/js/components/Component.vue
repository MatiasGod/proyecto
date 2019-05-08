<template>
    <div class="row">
        <div class="col-sm-4">
            <h1>VUEjs y Laravel</h1>
            {{partidos}}
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Agua de coco.')
        },
        /* created: function() {
            this.getTask();
        }, */
        data() {
            return  {
                partidos: 'asdasdasd'
            }
        },// Normal sin AJAX
        /* methods: {
            getTask: function() {
                axios.get('task').then(response => {
                    this.lists = response.data;
                    console.log(this.lists);
                });
            }
        } */
        // AJAX 

        /* mounted() {
            axios.get('match_view').then(response => {this.partidos = response.data});
        }, */
    };
</script>
