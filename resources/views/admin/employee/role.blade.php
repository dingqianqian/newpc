@extends("admin.layout.layout")
        @section("title","分配角色")
        @section("content")
    <div class="content-wrapper">
        <!-- Content Header -->
        <section class="content-header">
            <div class="panel panel-default">
                <div class="panel-body">
                    <b>
                        <a href="javascript:;">宜优速 管理中心</a>
                    </b>
                    <b>-分配角色</b>
                    <span class="pull-right">
			<a href="{{route('employee.list')}}" class="btn btn-default btn-xs"><i></i>管理员列表</a>
		</span>
                </div>
            </div>
        </section>

        <!-- 内容 -->
        <section class="content container-fluid">
            <form style="padding: 8px;overflow: hidden;" class="form table-responsive" style="overflow-x: hidden" action="{{url('admin/employee/distributeRole')}}/{{$id}}" method="post">
                <div class="row">
                    <div class="col-xs-12">
                            <div class="checkbox">
                            @foreach($roleInfo as $k=>$v)
                                <!-- 在此循环-ly -->
                                <label style="margin-right: 10px;">
                                    <input type="checkbox" name="role_id[]" value="{{$v['id']}}" @if(in_array($v['id'],$roleId)) checked @endif>{{$v['name']}}
                                </label>
                                @endforeach
                            </div>
                    </div>
                </div>
                {{csrf_field()}}
                <!--提交-->
                <div class="submitBtn text-center">
                   {{-- <label style="margin-right: 10px;">
                        <input type="checkbox">全选
                    </label>--}}
                    <button type="submit" class="btn btn-success">确定</button>
                    <button type="reset" class="btn btn-primary">重置</button>
                </div>
            </form>
        </section>

        <!-- Footer -->
        @component("admin.layout.footer")
        @endcomponent
    </div>
@endsection

@section("js")

<script>
    // 全选
    $('.submitBtn>label>input').click(function(){
        var checked = $(this).prop('checked');

        $('#lyfenpeiRole .checkbox label>input').each(function(k,v){
            $(v).prop('checked',checked);
        });
    });
</script>
@endsection