<?php 
\Bitrix\Main\UI\Extension::load(["ui.vue3", "ui.ajax"]);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

<div id="vue-news-list"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
<script>

BX.ready(function () {
    if (typeof BX === "undefined") {
    console.error("BX or BitrixVue is not defined");
    return;
}

    BX.Vue3.BitrixVue.createApp({
        el: '#vue-news-list',
        data() {
            return {
                newsList: [],
            };
        },
        created() {
            this.fetchNews();
        },
        methods: {
            fetchNews() {
                BX.ajax({
                    url: '/bitrix/services/main/ajax.php?c=custom:ajax.news&action=getNewsList&mode=class',
                    method: 'POST',
                    data: {
                        sessid: BX.bitrix_sessid(),
                        IBLOCK_ID: <?=$arParams['IBLOCK_ID']?>,
                    },
                    dataType: 'json',
                    onsuccess: function(response) {
                        if (response.status === 'success') {
                            this.newsList = response.data.newsList;
                        }
                    }.bind(this),
                    onfailure: function(response) {
                       
                    }
                });
            },
        },
        template: `
            <div v-for="news in newsList" :key="news.id" class="news-item">
            <div class="card mb-3" style="max-width: 540px;">
            <div class="row g-0">
                <div class="col-md-4">
                <img :src="news.image" class="img-fluid rounded-start" :alt="news.name">
                </div>
                <div class="col-md-8">
                <div class="card-body">
                    <p class="card-text"><small class="text-muted">Автор: {{news.author}}</small></p>
                    <h5 class="card-title">{{ news.name }}</h5>
                    <p class="card-text">{{ news.name }}</p>
                    <p class="card-text"><small class="text-muted">{{news.date}}</small></p>
                    <p class="card-text"><small class="text-muted">{{news.tags}}</small></p>
                    <a :href="news.url" class="btn btn-success text-white">Читать далее</a>
                </div>
                
                </div>
            </div>           
        `,
    }).mount('#vue-news-list'); 
});
</script>

