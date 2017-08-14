<!-- START OF MENU -->
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
            <li>
                <a href="{{ url('/') }}"><i class="glyphicon glyphicon-home"></i>&nbsp;Inicio</a>
            </li>
            <?php
                $cont = 0;
                $id_module = 0;
                $user = Auth::user();
                $opciones_perfil = DB::table('types_profile')
                    ->where('id_type', '=', $user->type)
                    ->join('submodules', 'types_profile.id_module', '=', 'submodules.id')
                    ->join('modules', 'modules.id', '=', 'submodules.modules_id')
                    ->select('modules.description as mdescription','icon','modules.id','submodules.description as sdescription','submodules.url as surl')
                    ->orderBy('modules.order','asc')
                    ->orderBy('submodules.order','asc')
                    ->get();
                foreach($opciones_perfil as $opcion_perfil):
                    if($opcion_perfil->id != $id_module){
                        $id_module = $opcion_perfil->id;
                        if($cont > 0){
                            print("</ul>
                                <!-- /.nav-second-level -->
                            </li>");
                        }
                        $cont++;
            ?>
            <li>
                <a href="#"><i class="<?php echo $opcion_perfil->icon; ?>"></i>&nbsp;<?php echo $opcion_perfil->mdescription; ?><span class="fa arrow"></span></a>
                <!-- .nav-second-level -->
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{ url('/') }}<?php echo "/".$opcion_perfil->surl; ?>">&nbsp;<?php echo $opcion_perfil->sdescription; ?></a>
                    </li>
            <?php
                    }else{
            ?>
                    <li>
                        <a href="{{ url('/') }}<?php echo "/".$opcion_perfil->surl; ?>">&nbsp;<?php echo $opcion_perfil->sdescription; ?></a>
                    </li>
            <?php   }
                endforeach 
            ?>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
<!-- /.navbar-static-side -->
<!-- END OF MENU -->