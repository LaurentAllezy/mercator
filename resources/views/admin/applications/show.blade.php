@extends('layouts.admin')
@section('content')

<div class="form-group">

    <a class="btn btn-default" href="{{ route('admin.applications.index') }}">
        {{ trans('global.back_to_list') }}
    </a>

    <a class="btn btn-success" href="{{ route('admin.report.explore') }}?node=APP_{{$application->id}}">
        {{ trans('global.explore') }}
    </a>

    @if(auth()->user()->can('m_application_edit') && auth()->user()->can('is-cartographer-m-application', $application))
        <a class="btn btn-info" href="{{ route('admin.applications.edit', $application->id) }}">
            {{ trans('global.edit') }}
        </a>
    @endif

    @if(auth()->user()->can('m_application_delete') && auth()->user()->can('is-cartographer-m-application', $application))
        <form action="{{ route('admin.applications.destroy', $application->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="submit" class="btn btn-danger" value="{{ trans('global.delete') }}">
        </form>
    @endif

</div>

<div class="card">
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-header">
        {{ trans('cruds.application.title_singular') }}
    </div>
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <dt>{{ trans('cruds.application.fields.name') }}</dt>
                {{ $application->name }}
            </div>
            @if (auth()->user()->granularity>=2)
            <div class="col-md-4">
                <dt>{{ trans('cruds.application.fields.application_block') }}</dt>
                    @if ($application->application_block!=null)
                    <a href='{{ route("admin.application-blocks.show", $application->application_block->id) }}'>{{ $application->application_block->name }}</a>
                    @endif
            </div>
            @endif
        </div>
        <br>
        <dt>{{ trans('cruds.application.fields.description') }}</dt>
        {!! $application->description !!}
    </div>

    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-header">
        {{ trans("cruds.menu.ecosystem.title_short") }}
    </div>
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.responsible') }}</dt>
                    {{ $application->responsible }}
                </div>
            </div>
            @if (auth()->user()->granularity>=2)
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.entity_resp') }}</dt>
                    @if ($application->entity_resp_id!=null)
                    <a href="{{ route('admin.entities.show', $application->entity_resp_id) }}">
                        {{ $application->entity_resp->name ?? '' }}
                    </a>
                    @endif
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.entities') }}</dt>
                    @foreach($application->entities as $entity)
                        <a href="{{ route('admin.entities.show', $entity->id) }}">{{ $entity->name }}</a>
                        @if(!$loop->last)
                        ,
                        @endif
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        <div class="row">
            <div class="col-md-4">
                <dt>{{ trans('cruds.application.fields.functional_referent') }}</dt>
                {{ $application->functional_referent }}
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.editor') }}</dt>
                    {{ $application->editor }}  
                </div>
            </div>
            @if (auth()->user()->granularity>=2)
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.users') }}</dt>
                    {{ $application->users }}                        
                </div>
            </div>
            @endif
            <div class="col-md-4">
                <div class="form-group">
                 <dt>{{ trans('cruds.application.fields.cartographers') }}</dt>
                 @foreach($application->cartographers as $cartographer)
                 {{ $cartographer->name }} @if(!$loop->last)-@endif
                 @endforeach
                </div>
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-header">
            {{ trans("cruds.menu.logical_infrastructure.title_short") }}
    </div>
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.technology') }}</dt>
                    {{ $application->technology }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.type') }}</dt>
                    {{ $application->type }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.external') }}</dt>
                    {{ $application->external }} 
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.install_date') }}</dt>
                    {{ $application->install_date }}
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.update_date') }}</dt>
                    {{ $application->update_date }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.events') }}</dt>
                    <button class="btn btn-info events_list_button">
                    {{ trans('cruds.application.fields.events_list_button') }}
                    </button>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                @if (auth()->user()->granularity>=2)
                    <dt>{{ trans('cruds.application.fields.documentation') }}</dt>
                    {{ $application->documentation }}
                @endif
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.databases') }}</dt>
                    @foreach($application->databases as $database)
                        <a href="{{ route('admin.databases.show', $database->id) }}">{{ $database->name }}</a>
                        @if(!$loop->last)
                        ,
                        @endif
                    @endforeach
                </div>
            </div>
            <div class="col-md-4">
                @if (auth()->user()->granularity>=2)
                <div class="form-group">
                    <dt>{{ trans('cruds.application.fields.services') }}</dt>
                    @foreach($application->services as $service)
                        <a href="{{ route('admin.application-services.show', $service->id) }}">{{ $service->name }}</a>
                        @if(!$loop->last)
                        ,
                        @endif
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-header">
        Sécurité
    </div>
    <!------------------------------------------------------------------------------------------------------------->
    <div class="card-body">
      <div class="row">
        <div class="col-md-5">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.security_need') }}</dt>
                <table cellspacing="5" cellpadding="5" border="0" width='100%'>
                    <td align="right" valign="bottom">
                        {{ trans("global.confidentiality") }}</dt>
                    </td>
                    <td>
                    @if ($application->security_need_c==0){{ trans('global.none') }}@endif
                    @if ($application->security_need_c==1)<span class="veryLowRisk">{{ trans('global.low') }}</span>@endif
                    @if ($application->security_need_c==2)<span class="lowRisk">{{ trans('global.medium') }}</span>@endif
                    @if ($application->security_need_c==3)<span class="mediumRisk">{{ trans('global.strong') }}</span>@endif
                    @if ($application->security_need_c==4)<span class="highRisk">{{ trans('global.very_strong') }}</span>@endif
                    </td>
                    <td align="right" valign="bottom">
                        {{ trans("global.integrity") }}
                    </td>
                    <td>                        
                    @if ($application->security_need_i==0){{ trans('global.none') }}@endif
                    @if ($application->security_need_i==1)<span class="veryLowRisk">{{ trans('global.low') }}</span>@endif
                    @if ($application->security_need_i==2)<span class="lowRisk">{{ trans('global.medium') }}</span>@endif
                    @if ($application->security_need_i==3)<span class="mediumRisk">{{ trans('global.strong') }}</span>@endif
                    @if ($application->security_need_i==4)<span class="highRisk">{{ trans('global.very_strong') }}</span>@endif
                    </td>
                    <td>                        
                        {{ trans('global.availability') }}
                    </td>
                    <td>                        
                    @if ($application->security_need_a==0){{ trans('global.none') }}@endif
                    @if ($application->security_need_a==1)<span class="veryLowRisk">{{ trans('global.low') }}</span>@endif
                    @if ($application->security_need_a==2)<span class="lowRisk">{{ trans('global.medium') }}</span>@endif
                    @if ($application->security_need_a==3)<span class="mediumRisk">{{ trans('global.strong') }}</span>@endif
                    @if ($application->security_need_a==4)<span class="highRisk">{{ trans('global.very_strong') }}</span>@endif
                    </td>
                    <td>                        
                        {{ trans('global.tracability') }}
                    </td>
                    <td>                        
                    @if ($application->security_need_t==0){{ trans('global.none') }}@endif
                    @if ($application->security_need_t==1)<span class="veryLowRisk">{{ trans('global.low') }}</span>@endif
                    @if ($application->security_need_t==2)<span class="lowRisk">{{ trans('global.medium') }}</span>@endif
                    @if ($application->security_need_t==3)<span class="mediumRisk">{{ trans('global.strong') }}</span>@endif
                    @if ($application->security_need_t==4)<span class="highRisk">{{ trans('global.very_strong') }}</span>@endif
                </td>
            </table>
            </div>
        </div>

        <div class="col-sm-1">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.RTO') }}</dt>
                    @if (intdiv($application->rto,60 * 24) > 0)
                        {{ intdiv($application->rto,60 * 24) }}
                        @if (intdiv($application->rto,60 * 24) > 1)
                            {{ trans('global.days') }}
                        @else
                            {{ trans('global.day') }}
                        @endif
                    @endif
                    @if ((intdiv($application->rto,60) % 24) > 0)
                        {{ intdiv($application->rto,60) % 24 }}
                        @if ((intdiv($application->rto,60) % 24) > 1)
                            {{ trans('global.hours') }}
                        @else
                            {{ trans('global.hour') }}
                        @endif
                    @endif
                    @if (($application->rto % 60) > 0)
                        {{ $application->rto % 60 }}
                        @if (($application->rto % 60) > 1)
                            {{ trans('global.minutes') }}
                        @else
                            {{ trans('global.minute') }}
                        @endif
                    @endif
            </div>
        </div>
        <div class="col-sm-1">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.RPO') }}</dt>
                {{ intdiv($application->rpo,60 * 24) }}
                @if (intdiv($application->rpo,60 * 24) > 0)
                    @if (intdiv($application->rpo,60 * 24) > 1)
                        {{ trans('global.days') }}
                    @else
                        {{ trans('global.day') }}
                    @endif
                @endif
                @if ((intdiv($application->rpo,60) % 24) > 0)
                    {{ intdiv($application->rpo,60) % 24 }}
                    @if ((intdiv($application->rpo,60) % 24) > 1)
                        {{ trans('global.hours') }}
                    @else
                        {{ trans('global.hour') }}
                    @endif
                @endif    
                @if (($application->rpo % 60) > 0)
                    {{ $application->rpo % 60 }}
                    @if (($application->rpo % 60) > 1)
                        {{ trans('global.minutes') }}
                    @else
                        {{ trans('global.minute') }}
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!------------------------------------------------------------------------------------------------------------->
<div class="card-header">
    Common Plateforme Enumeration (CPE)
</div>

<div class="card-body">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.vendor') }}</dt>
                {{ $application->vendor }}
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.product') }}</dt>
                {{ $application->product }}
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.version') }}</dt>
                {{ $application->version }}
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------->
<div class="card-header">
    {{ trans("cruds.menu.metier.title_short") }}
</div>
<!------------------------------------------------------------------------------------------------------------->
<div class="card-body">
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.processes') }}</dt>
                @foreach($application->processes as $process)
                    <a href="{{ route('admin.processes.show', $process->id) }}">{{ $process->identifiant }}</a>
                    @if(!$loop->last)
                    ,
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
<!------------------------------------------------------------------------------------------------------------->
<div class="card-header">
    {{ trans("cruds.menu.logical_infrastructure.title_short") }}
</div>
<!------------------------------------------------------------------------------------------------------------->
<div class="card-body">
    <div class="row">
        <div class="col-sm">
            <div class="form-group">
                <dt>{{ trans('cruds.application.fields.logical_servers') }}</dt>
                @foreach($application->logical_servers as $logical_server)
                    <a href='{{ route("admin.logical-servers.show", $logical_server->id) }}'>{{ $logical_server->name }}</a>
                    @if(!$loop->last)
                    ,
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
   <div class="card-footer">
        {{ trans('global.created_at') }} {{ $application->created_at ? $application->created_at->format(trans('global.timestamp')) : '' }} |
        {{ trans('global.updated_at') }} {{ $application->updated_at ? $application->updated_at->format(trans('global.timestamp')) : '' }} 
    </div>
</div>

    <div class="form-group">
        <a class="btn btn-default" href="{{ route('admin.applications.index') }}">
            {{ trans('global.back_to_list') }}
        </a>
    </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function () {
        // Variable contenant la liste des évènements affichés sur la popup
        var swalHtml = @json($application->events);

        /**
         * Contruction de la liste des évènements
         * @returns {string}
         */
        function makeHtmlForSwalEvents() {
            let events = swalHtml;
            let ret = '<ul>';
            events.forEach (function(event) {
                ret += '<li data-id="'+event.id+'" style="text-align: left; margin-bottom: 20px;">'+event.message+'</br>';
                ret += '<span style="font-size: 12px;">Date : '+ moment(event.created_at).format('DD-MM-YYYY') +' | Utilisateur : '+event.user.name+'</span>';
            });
            ret += '</ul>';
            return ret;
        }

        /**
         * Fire the popup
         */
        $('.events_list_button').click(function(e) {
            e.preventDefault()
            Swal.fire({
                title: 'Évènements',
                icon: 'info',
                html: makeHtmlForSwalEvents(),
                showCloseButton: true
            });
        });
    });
</script>
@endsection
