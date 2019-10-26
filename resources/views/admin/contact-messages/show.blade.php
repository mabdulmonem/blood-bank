@extends('admin.layouts.index')

@section('content')

    <div class="col-md-12">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Read Mail</h3>

                <div class="card-tools">
                    <a href="{{ admin_url("contact-messages/" . ($page = calc($mail->id - 1) <= 0) ? null : $page)  }}" class="btn btn-tool" data-toggle="tooltip"
                       title="Previous"><i class="fas fa-chevron-left"></i></a>
                    <a href="{{ admin_url("contact-messages/" . ($page = calc($mail->id + 1) < $quantity)) ? $page : str_replace('-','',$page - $quantity) }}" class="btn btn-tool" data-toggle="tooltip"
                       title="Next"><i class="fas fa-chevron-right"></i></a>

                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
                <div class="mailbox-read-info">
                    <h5>{{ $mail->subject }}</h5>
                    <h6>From: {{ $mail->email }}
                        <span class="mailbox-read-time float-right">{{ $mail->created_at }}</span></h6>
                </div>
                <!-- /.mailbox-read-info -->
                <div class="mailbox-read-message">
                    {{ $mail->message }}
                </div>
                <!-- /.mailbox-read-message -->
            </div>
            <!-- /.card-footer -->
            <div class="card-footer">
                <div class="float-right">
                    <a href="{{ admin_url("replay/mail/$mail->id") }}" class="btn btn-default"><i class="fas fa-reply"></i> Reply</a>
                </div>
                <form action="{{ route('contact-messages.destroy', $mail->id) }}" method="POST" class="form-delete">
                    @method('DELETE')
                    @csrf
                    <button type="submit" class="btn btn-danger"><i class="far fa-trash-alt"></i> Delete</button>
                </form>
            </div>
            <!-- /.card-footer -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.col -->
@endsection
