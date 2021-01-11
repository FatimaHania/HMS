<style>

 .module-item {
     border-top:2px solid white;
     padding-top:5px;
     padding-bottom:5px;
     border-right:none;
 }

 .checkbox-span{
 }

</style>
@php
    $usergroup_module_arr = array();
@endphp

@foreach($usergroup_modules as $usergroup_module)
    @php $usergroup_module_arr[] = $usergroup_module->id; @endphp
@endforeach

<!--Building the module tree-->
@php
$data = array();
@endphp

@foreach($modules as $menu)

  @php

if ($menu->route == "" || $menu->route == null) {
    $route = '#';
} else {
    $route = route($menu->route);
}

  $data[] = array(
      'id' => $menu->id,
      'module_id' => $menu->id,
      'menu_name' => $menu->menu_name,
      'menu_icon' => $menu->menu_icon,
      'page_name' => $menu->page_name,
      'route' => $route,
      'is_external_link'=>$menu->is_external_link,
      'master_module_id' => $menu->master_module_id
  );

  @endphp

@endforeach

  <?php
  
$menu_data = $data;
function buildTree(array $elements, $parentId = 0)
{
    $branch = array();

    foreach ($elements as $element) {
        if ($element['master_module_id'] == $parentId) {
            $children = buildTree($elements, $element['id']);
            if ($children) {
                $element['children'] = $children;
            }
            $branch[] = $element;
        }
    }

    return $branch;
}

$tree = buildTree($menu_data);
function createMenu($tree, $stat, $usergroup_module_arr, $padding = '0')
{
    $a = 0;
    foreach ($tree as $row) {

        
        $background_colour = "#f0f7ff";

        $module_id_field = '<input type="hidden" id="module_id'.$row['module_id'].'" name="module_id[]" value="'.$row['module_id'].'">';
        $master_module_id_field = '<input type="hidden" id="master_module_id'.$row['module_id'].'" name="master_module_id[]" value="'.$row['master_module_id'].'">';
        
        //check if the module belongs to the usergroup
        if(in_array($row['module_id'], $usergroup_module_arr)){
            $selected_value_field = '<input type="hidden" class="master_module'.$row['master_module_id'].'" id="selected_value'.$row['module_id'].'" name="selected_value[]" value="1">';
            $checkbox = '<input type="checkbox" class="icheck-checkbox master_module_CB'.$row['master_module_id'].'" id="selected_CB'.$row['module_id'].'" data-module-id-CB="'.$row['module_id'].'" data-master-module-id-CB="'.$row['master_module_id'].'" checked>';
        } else {
            $selected_value_field = '<input type="hidden" class="master_module'.$row['master_module_id'].'" id="selected_value'.$row['module_id'].'" name="selected_value[]" value="0">';
            $checkbox = '<input type="checkbox" class="icheck-checkbox master_module_CB'.$row['master_module_id'].'" id="selected_CB'.$row['module_id'].'" data-module-id-CB="'.$row['module_id'].'" data-master-module-id-CB="'.$row['master_module_id'].'">';
        }

        echo $module_id_field;
        echo $master_module_id_field;
        echo $selected_value_field;
 
        if (array_key_exists("children", $row)) {

            echo '<div class="module-item module-dropdown" style="background-color:'.$background_colour.'; padding-left:'.$padding.'px;"><span>'. (str_repeat('&nbsp;', 3)).  $row['menu_name'] . '</span><span class="pull-right checkbox-span">'.$checkbox.'</span>

                                <div class="module-dropdown-items">';
            createMenu($row['children'], '1', $usergroup_module_arr, ($padding+20));
            echo '</div>
                            </div>';

        } else {
            echo '<div class="module-item" style="background-color:'.$background_colour.';  padding-left:'.$padding.'px;"><span>'. (str_repeat('&nbsp;', 3)) .  $row['menu_name'] . '</span><span class="pull-right checkbox-span">'.$checkbox.'</span></div>';
        }
        $a++;


    }
}
?>

{{createMenu($tree, '0', $usergroup_module_arr)}}

@stack('scripts')
<script>
    $(document).ready(function(){
        $('.icheck-checkbox').iCheck({
            checkboxClass: 'icheckbox_square-purple',
            radioClass: 'iradio_square-purple',
            increaseArea: '20%' // optional
        });

        //oncheck event on checkbox
        $('.icheck-checkbox').on('ifChecked', function(event){
            var module_id = $(this).attr('data-module-id-CB');
            var master_module_id = $(this).attr('data-master-module-id-CB');

            //update selected check box value
            $('#selected_value'+module_id).val('1');

            //select all sub modules
            $('.master_module'+module_id).val('1');
            $('.master_module_CB'+module_id).prop('checked',true).iCheck('update');

            //select the master module
            $('#selected_value'+master_module_id).val('1');
            $('#selected_CB'+master_module_id).prop('checked',true).iCheck('update');
        });


        //on uncheck event on checkbox
        $('.icheck-checkbox').on('ifUnchecked', function(event){
            var module_id = $(this).attr('data-module-id-CB');
            var master_module_id = $(this).attr('data-master-module-id-CB');

            //update unselected check box value
            $('#selected_value'+module_id).val('0');

            //unselect all sub modules
            $('.master_module'+module_id).val('0');
            $('.master_module_CB'+module_id).prop('checked',false).iCheck('update');

            //unselect the master module
            var selected_sub_modules = $('[value="1"].master_module'+master_module_id).length;
            if(selected_sub_modules < 1) { 
                $('#selected_value'+master_module_id).val('0');
                $('#selected_CB'+master_module_id).prop('checked',false).iCheck('update');
            }

        });

    });

</script>