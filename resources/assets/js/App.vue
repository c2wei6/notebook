<template>
    <div>
        <router-view></router-view>
        <mt-tabbar>
            <mt-tab-item>
                <img slot="icon" src="/100*100.png" alt="">
                待办
            </mt-tab-item>
            <mt-tab-item>
                <img slot="icon" src="/100*100.png" alt="">
                随笔
            </mt-tab-item>
            <mt-tab-item>
                <img slot="icon" src="/100*100.png" alt="">
                笔记
            </mt-tab-item>
        </mt-tabbar>
    </div>
</template>

<script>
    import { Tabbar, TabItem } from 'mint-ui'

    export default {
        name: "App"
    }
</script>

<style>
    * {
        margin: 0;
        padding: 0;
    }
</style>
