define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 添加按钮'data-area'属性,窗口全屏
            $(".btn-add").data("area", ["90%","100%"]);
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'goods/index/index',
                    add_url: 'goods/index/add',
                    edit_url: 'goods/index/edit',
                    del_url: 'goods/index/del',
                    multi_url: 'goods/index/multi',
                    table: 'goods',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'sort',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), operate:false},
                        {field: 'title', title: __('Title')},
                        {field: 'category.name', title: __('Category_id') , operate: '='},
                        {field: 'type', title: __('Type'), visible:false, searchList: {"1":__('Type 1'),"2":__('Type 2')}},
                        {field: 'type_text', title: __('Type'), operate:false},
                        {field: 'pic', title: __('Pic'), operate:false , formatter: Table.api.formatter.image},
                        {field: 'pics', title: __('Pics'), visible:false, operate:false},
                        {field: 'sale_price', title: __('Sale_price'), operate:'BETWEEN'},
                        {field: 'market_price', title: __('Market_price'), operate:'BETWEEN'},
                        {field: 'cost_price', title: __('Cost_price'), operate:'BETWEEN'},
                        {field: 'weight', title: __('Weight'), operate:false},
                        {field: 'last_num', title: __('Last_num')},
                        {field: 'is_sale', title: __('Is_sale'), visible:false, searchList: {"1":__('Is_sale 1'),"2":__('Is_sale 2')}},
                        {field: 'is_sale_text', title: __('Is_sale'), operate:false},
                        {field: 'sort', title: __('Sort'), operate:false},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);

        },
        add: function () {
            //追加控制
            $(".btn-append").on("click", function () {
                
                var select_len = $('.format_type').find('select').length;//slect的长度
                if(select_len == 2){
                    return false;
                }else{
                    if (select_len == 0) {
                        var num = 1;
                    }else if(select_len == 1){
                        var num = 2;
                    }
                    
                    var html = '';
                        html += '<div class="" style="margin-top:10px">';
                        html += '<select style="width:30%" class="form-control" flag="'+num+'" name="attrk'+num+'[]" onchange="addMoreFormat(this)">';
                        html += '<option value="">请选择</option>';
                            
                        html += '<option value="1-颜色">颜色</option>';
                        html += '<option value="2-尺码">尺码</option>';
                            
                        html += '</select>';
                        html += '<span style="margin-left:100px;font-size:16px"><a href="javascript:;" onclick="delFormatType(this)">删除规格</a></span>';
                        html += '</div>';
                        
                    // 把新的下拉框添加到
                    $(this).parent().append(html);
                        
                }
                
                
            });

        // 弹窗
        // $(".btn-append").on('click',  function() {
        //    layer.open({
        //       type: 1,
        //       area: ['80%', '80%'], //宽高
        //       content: 'html内容'
        //     });
        // });
            
            Controller.api.bindevent();
            

        },
        edit: function () {
            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});


function addMoreFormat(select){
    var chose_value = $(select).val(); //value值
    // var chose_text = select.options[chose_value].text; //option值
    // var select_name = $(select).attr('name'); //name值
    var flag = $(select).attr('flag'); // 标记值
    // alert(flag);
    if ($(select).parent().find('input').length >= 1) {
        return false;
    }else{
        if (chose_value != '') {
            var html = '<div><input class="form-control" name="attrv'+flag+'[]" flag="'+flag+'" type="text" value="" style="width:100px;margin-top:10px" onBlur="sendDataTo(this)"><a href="javascript:;" style="font-size:16px;margin-left:10px" onclick="addMoreFormatAttr(this , '+flag+')">添加</a></div>';
            $(select).parent().append(html);
        }
    }

};

// 添加更多属性
function addMoreFormatAttr(btn , flag){
    var input = '<input class="form-control" name="attrv'+flag+'[]" flag="'+flag+'" type="text" value="" style="width:100px;margin-top:10px;margin-left:10px" onBlur="sendDataTo(this)">';
    if ($(btn).prev().val() == '') {
        Toastr.warning('规格名称不能为空');
    }else{
        $(btn).prev().attr('readonly' , 'readonly');
        $(btn).prev().after('<a href="#" style="font-size:18px;color:red" onclick="delFormatAttr(this)"><i class="fa fa-times-circle"></i></a>');
        $(btn).before(input);
    }
    
};


// 生成表格
function sendDataTo(input){
    // var attrv_name = $(input).attr('name'); // name值
    // var attrv_flag = $(input).attr('flag'); // flag值
    // // alert(attrv_flag);
    // var attrk_v = $(".format_type select[name='attrk"+attrv_flag+'[]'+"']").val();
    // var attrk_k = $(".format_type select[name='attrk"+attrv_flag+'[]'+"']").find('option:selected').text();
    // // alert(attrk_k);
    // var attrv_v = $(input).val();
    // var param_k = 'attrk'+attrv_flag;
    // var param_v = 'attrv'+attrv_flag;

    // var all_form_data = $( "form" ).serialize();
    // alert(attrv_v);
    
    // if($(input).val() != ''){

        $.ajax({
            url: '/admin/goods/index/getFormatInfo',
            type: 'POST',
            dataType: 'json',
            data: serializeNotNull($( "form" ).serialize()),
            success : function(data){
                // console.log(JSON.stringify(data));
                if(data.code != 404){
                var html = '';
                    html += '<table id="table" class="table table-striped table-bordered table-hover table-nowrap" data-operate-edit="1" data-operate-del="1" width="100%">';
                    html += '<tr>';
                    html += '<th>'+data.k+'</th>';
                    if(data.k2){
                        html += '<th>'+data.k2+'</th>';
                    }
                    html += '<th>库存</th>';
                    html += '<th>价格</th>';
                    html += '<th>编码</th>';
                    html += '</tr>';

                    if (data.v2) {
                        
                        for (var i = data.v.length - 1; i >= 0; i--) {
                            for (var j = data.v2.length - 1; j >= 0; j--) {
                                html += '<tr>';
                                html += '<td>'+data.v[i]+'</td>';
                                html += '<td>'+data.v2[j]+'</td>';
                                html += '<td><input type="text" name="" value=""></td>';
                                html += '<td><input type="text" name="" value=""></td>';
                                html += '<td><input type="text" name="" value=""></td>';
                                html += '</tr>';
                            }
                            
                        }
                    }else{
                        for (var i = data.v.length - 1; i >= 0; i--) {
                            
                            html += '<tr>';
                            html += '<td>'+data.v[i]+'</td>';
                            html += '<td><input type="text" name="" value=""></td>';
                            html += '<td><input type="text" name="" value=""></td>';
                            html += '<td><input type="text" name="" value=""></td>';
                            html += '</tr>';
                        }
                    }
                    
                    html += '</table>';

                    $("#SKU-table").html('');
                    $("#SKU-table").append(html);
                }else{
                    $("#SKU-table").html('');
                }
            }
        })
        
    // }   
    
   
    
};

// 删除规格
function delFormatType(btn) {
    var flag = $(btn).parent().prev().attr('flag');
    if (flag == 1) {
        $(".btn-append").nextAll().remove();
        $("#SKU-table").html('');
    }else{
        $(btn).parent().parent().remove();
        sendDataTo();
    }
    // alert(flag);
}

function delFormatAttr(btn){
    $(btn).prev().remove();
    $(btn).remove();
    sendDataTo();
}


// 过滤序列化后的空值
function serializeNotNull(serStr){
    return serStr.split("&").filter(function(str){return !str.endsWith("=")}).join("&");
}