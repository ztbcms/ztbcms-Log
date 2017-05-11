<Admintemplate file="Admin/Common/Head"/>
<body class="J_scroll_fixed">
<div id="app" class="wrap J_check_wrap">
    <Admintemplate file="Admin/Common/Nav"/>
    <div class="h_a">搜索</div>
    <div class="search_type cc mb10">
        <div class="mb10">
            <span class="mr20">
                用户ID：<input type="text" class="input length_2" name="uid" size='10' v-model="where.userid" placeholder="用户ID">
                类名：<input type="text" class="input length_2" name="uid" size='10' v-model="where.category" placeholder="类名">
                IP：<input type="text" class="input length_2" name="ip" size='20' v-model="where.ip" placeholder="IP">
                时间：
                <input type="text" name="start_time" class="input length_2 J_date" v-model="where.start_time" style="width:100px;">
                -
                <input type="text" name="end_time" class="input length_2 J_date" v-model="where.end_time" style="width:100px;">
                <button class="btn" v-on:click="search()">搜索</button>
            </span>
        </div>
    </div>
    <div class="table_list">
        <table width="100%" cellspacing="0">
            <thead>
            <tr>
                <td align="center" width="80">ID</td>
                <td align="center" width="80">用户ID</td>
                <td align="center" width="200">类名</td>
                <td align="center" >日志信息</td>
                <td align="center" width="160">时间</td>
                <td align="center" width="120">IP</td>
            </tr>
            </thead>
            <tbody>
            <tr v-for="item in logs">
                <td align="center">{{item.id}}</td>
                <td align="center">{{item.userid}}</td>
                <td align="center">{{item.category}}</td>
                <td align="center">{{item.message}}</td>
                <td align="center">{{item.inputtime|getFormatTime}}</td>
                <td align="center">{{item.ip}}</td>
            </tr>
            </tbody>
        </table>
        <div class="p10">
            <div class="pages">
                <div class="dataTables_paginate paging_simple_numbers">
                    <button v-on:click="toPage( parseInt(where.page) - 1 )" class="btn btn-primary">上一页</button>
                    <button v-on:click="toPage( parseInt(where.page) + 1 )" class="btn btn-primary">下一页</button>
                    <span style="line-height: 30px;margin-left: 50px"><input id="ipt_page" style="width:50px;" type="text" v-model="temp_page"> / {{ total_page }}</span>
                    <span><button class="btn btn-primary" v-on:click="toPage( temp_page )">GO</button></span>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{$config_siteurl}statics/js/vue/vue.js"></script>
<script>
    new Vue({
        el: '#app',
        data: {
            where: {
                userid : '{:I("userid","")}',
                category : '{:I("category","")}',
                start_time : '{:I("start_time","")}',
                end_time : '{:I("end_time","")}',
                ip : '{:I("ip","")}',
                page: 1
            },
            logs: {},
            temp_page: 1,
            total_page: 0
        },
        filters: {
            getFormatTime: function (value) {
                var time = new Date(parseInt(value * 1000));
                var y = time.getFullYear();
                var m = time.getMonth() + 1;
                var d = time.getDate();
                var h = time.getHours();
                var i = time.getMinutes();
                var res = y + '-' + (m < 10 ? '0' + m : m) + '-' + (d < 10 ? '0' + d : d) + '';
                res += '  ' + (h < 10 ? '0' + h : h) + ':' + (i < 10 ? '0' + i : i);
                return res;
            }
        },
        methods: {
            getList: function(){
                var that = this;
                $.ajax({
                    url: '{:U("Log/Index/index")}',
                    data: that.where,
                    type: 'POST',
                    dataType: 'json',
                    success: function(res){
                        if(res.status){
                            that.logs = res.data.logs;
                            that.where.page = res.data.page;
                            that.temp_page = res.data.page;
                            that.total_page = res.data.total_page;
                        }
                    }
                });
            },
            toPage: function (page) {
                this.where.page = page;
                if (this.where.page < 1) {
                    this.where.page = 1;
                }
                if (this.where.page > this.total_page) {
                    this.where.page = this.total_page;
                }
                this.getList();
            },
            search: function(){
                this.where.page = 1;
                this.where.start_time = $('input[name="start_time"]').val();
                this.where.end_time = $('input[name="end_time"]').val();
                this.getList();
            }
        },
        mounted: function(){
            this.getList();
        }
    });
</script>
<script src="{$config_siteurl}statics/js/common.js"></script>
</body>
</html>
