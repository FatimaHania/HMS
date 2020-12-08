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

        $module_id_field = '<input type="text" id="module_id'.$row['module_id'].'" name="module_id[]" value="'.$row['module_id'].'">';
        $master_module_id_field = '<input type="text" id="master_module_id'.$row['module_id'].'" name="master_module_id[]" value="'.$row['master_module_id'].'">';
        
        //check if the module belongs to the usergroup
        if(in_array($row['module_id'], $usergroup_module_arr)){
            $selected_value_field = '<input type="text" class="master_module'.$row['master_module_id'].'" id="selected_value'.$row['module_id'].'" name="selected_value[]" value="1">';
            $checkbox =  '<input type="checkbox" class="icheck-checkbox master_module_CB'.$row['master_module_id'].'" data-module-id-CB="'.$row['module_id'].'" data-master-module-id-CB="'.$row['master_module_id'].'" checked>';
        } else {
            $selected_value_field = '<input type="text" class="master_module'.$row['master_module_id'].'" id="selected_value'.$row['module_id'].'" name="selected_value[]" value="0">';
            $checkbox = '<input type="checkbox" class="icheck-checkbox master_module_CB'.$row['master_module_id'].'" data-module-id-CB="'.$row['module_id'].'" data-master-module-id-CB'.$row['master_module_id'].'>';
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

            $('#selected_value'+module_id).val('1');
            $('.master_module'+module_id).val('1');
            $('.master_module_CB'+module_id).iCheck('check');
        });


        //on uncheck event on checkbox
        $('.icheck-checkbox').on('ifUnchecked', function(event){
            var module_id = $(this).attr('data-module-id-CB');
            var master_module_id = $(this).attr('data-master-module-id-CB');

            $('#selected_value'+module_id).val('0');
            $('.master_module'+module_id).val('0');
            $('.master_module_CB'+module_id).iCheck('uncheck');

        });

    });

</script>