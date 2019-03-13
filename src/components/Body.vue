<template>
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow"></nav>
            <div class="container-fluid" v-html="content"></div>
        </div>
    </div>
</template>

<script>
export default {
    props: ['content'],
}
</script>