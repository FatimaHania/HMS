@php
$data = array();
@endphp

@foreach($menus as $menu)

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
function createMenu($tree, $stat)
{
    $a = 1;
    foreach ($tree as $row) {

        if (array_key_exists("children", $row)) {

            echo '<li class="nav-item nav-dropdown" id="' . $row['module_id'] . '">
                                <a class="nav-link nav-dropdown-toggle" href="#" id="' . $row['module_id'] . '"><i class="nav-icon icon-cursor ' . $row['menu_icon'] . '"></i> <span>' .  $row['menu_name'] . '</span></a>

                                <ul class="nav-dropdown-items">';
            createMenu($row['children'], '1');
            echo '</ul>
                            </li>';

        } else {

            if ($stat == '0') {
                if ($row['is_external_link'] == '0') {

                    echo '<li class="nav-item '.(Request::is($row['route'].'*') ? 'active' : ''). '" id="' . $row['module_id'] . '">
                                            <a class="nav-link" href="'.( $row['route']).'" id="' . $row['module_id'] . '"><i class="nav-icon icon-cursor ' . $row['menu_icon'] . '"></i> <span>' .  $row['menu_name'] . '</span></a>
                                      </li>';

                } else {

                    echo '<li class="nav-item '.(Request::is($row['route'].'*') ? 'active' : ''). '" id="' . $row['module_id'] . '">
                                        <a class="nav-link" href="'.( $row['route']).'"  id="' . $row['module_id'] . '" target="_blank"> <i class="nav-icon icon-cursor ' . $row['menu_icon'] . '"></i> <span>' .  $row['menu_name'] . '</span></a>
                                      </li>';
                }

            } else {
                
                echo '<li class="nav-item '. (Request::is($row['route'].'*') ? 'active' : '').'"  id="'.$row['module_id'].'"><a class="nav-link" href="'.($row['route']).'" id="'. $row['module_id']. '"><i class="nav-icon cil-circle '. $row['menu_icon'] .'"></i> <span>'. $row['menu_name'] .'</span></a></li>';
                
            }

        }
        $a++;
    }
}
?>

            
            {{createMenu($tree, '0')}}

<!-- <li class="nav-item {{ Request::is('titles*') ? 'active' : '' }}">
    <a class="nav-link" href="{{ route('titles.index') }}">
        <i class="nav-icon icon-cursor"></i>
        <span>Titles</span>
    </a>
</li> -->