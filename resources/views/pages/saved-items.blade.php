<?php
/**
 * This file (profile.blade.php) was created on 06/19/2016 at 16:17.
 * (C) Max Cassee
 * This project was commissioned by HU University of Applied Sciences.
 */
?>
@extends('layout.HUdefault')
@section('title')
    {{ __('saved_learning_items.saved-items') }}
@stop
@section('content')
<?php
use App\Student;
use App\SavedLearningItem
/** @var Student $student */;
/** @var SavedLearningItem $sli */
/** @var Folder $folder */?>

    <div class="container-fluid">
        @card
        <h1>{{ __('saved_learning_items.saved') }}</h1>
        <div class="row">
            <div class="col-md-12">
                @card
                    <h2 class='maps'>{{ __('saved_learning_items.timeline') }}</h2>
                    <br>
                    @foreach($sli as $item)
                    <!-- Tips -->
                        @if($item->category === 'tip')
                            @card
                            <h4 class="maps">{{date('d-m-Y', strtotime($item->created_at))}}</h4>
                            <div class="alert" style="background-color: #00A1E2; color: white; margin-left:2px; margin-bottom: 10px" role="alert">
                                <a href="{{ route('saved-learning-items-delete', ['sli' => $item])}}" onclick="return confirm('{{ __('saved_learning_items.delete-confirmation') }}')"><span class="glyphicon glyphicon-trash delete-tip" aria-hidden="true"></span></a>
                                <a onclick="chooseItem({{ $item->sli_id }})" data-target="#addItemModel" data-toggle="modal"><span class="glyphicon glyphicon-plus add-tip" aria-hidden="true"></span></a>
                                <h4 class="tip-title">{{ __('tips.personal-tip') }}</h4>
                                @if (in_array($item->item_id, array_keys($evaluatedTips)))
                                    <p>{{$evaluatedTips[$item->item_id]->getTipText()}}</p>
                                @else
                                    <p>{{ __('saved_learning_items.tip-not-found') }}</p>
                                @endif
                            </div>
                            @endcard
                        @endif
                    @endforeach

                     <!-- Activities -->
                     @foreach($activities as $activity)
                            @card
                            <h4 class="maps">{{date('d-m-Y', strtotime($item->created_at))}}</h4>
                            <div class="alert" style="background-color: #00A1E2; color: white; margin-left:2px; margin-bottom: 10px" role="alert">
                                <h4>Activiteit</h4>
                                <p><strong>{{date('d-m-Y', strtotime($activity->date))}}</strong>: {{$activity->description}}</p>
                                <span class="glyphicon glyphicon-time activity_icons" aria-hidden="true"></span>{{$activity->duration}} uur
                                <br><span class="glyphicon glyphicon-user activity_icons" aria-hidden="true"></span>{{$activity->duration}} uur
                                <br><span class="glyphicon glyphicon-tag activity_icons" aria-hidden="true"></span>{{$activity->duration}} uur
                            </div>
                            @endcard
                        @endforeach
                @endcard

            </div>
         </div>
    </div>
    @endcard
    <!-- Modal to add a item to folder-->
    <div class="modal fade" id="addItemModel" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ __('folder.add-to-folder') }}</h4>
        </div>
        <div class="modal-body">

        {!! Form::open(array('url' =>  route('saved-learning-item.updateFolder'))) !!}

            <div class="form-group">
                <input type='text' name='sli_id' id="sli_id" class="form-control">
            </div>

            <div class="form-group">
                <select name="chooseFolder" class="form-control">
                    @foreach($student->folders as $folder)
                        <option value="{{$folder->folder_id}}">{{$folder->title}}</option>
                    @endforeach
                </select>
            </div>

            </div>
            <div class="modal-footer">
                {{ Form::submit(__('general.save'), array('class' => 'btn btn-primary', 'id' => 'addItemToFolder')) }}
                {{ Form::close() }}
            </div>
      </div>
      
    </div>
    </div>

      <!-- Modal to add a folder-->
    <div class="modal fade" id="addFolderModel" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ __('folder.new-folder') }}</h4>
        </div>
        <div class="modal-body">

        {!! Form::open(array('url' =>  route('folder.create'))) !!}
            <div class="form-group">
                <label>{{ __('folder.title') }}</label>
                <input id='folderTitle' type='text' name='folder_title' class="form-control" maxlength="100" required>
            </div>
                          
            <div class="form-group">
                <label>{{ __('folder.description') }}</label>
                <textarea type='text' name='folder_description' id="folderDescription" class="form-control" maxlength="255" required></textarea>
            </div>
            

        <div class="modal-footer">
            {{ Form::submit(__('general.save'), array('class' => 'btn btn-primary', 'id' => 'saveButton')) }}
            {{ Form::close() }}
        </div>
      </div>
      
    </div>
  </div>
  
</div>
@include('js.learningitem_save')
@stop