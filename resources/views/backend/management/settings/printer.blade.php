@extends('backend.layouts.app')
@section('content')
<div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><i class="ti ti-printer me-2"></i>Thermal Printer Setup</h5>
                        <span class="badge bg-light-primary text-primary">ESC/POS Protocol</span>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Connection Type</label>
                                    <select name="printer_connection" class="form-control">
                                        <option value="usb" {{ get_setting('printer_connection') == 'usb' ? 'selected' : '' }}>USB (Local)</option>
                                        <option value="network" {{ get_setting('printer_connection') == 'network' ? 'selected' : '' }}>Network (Ethernet/IP)</option>
                                    </select>
                                </div>

                                <div class="col-md-8 mb-3">
                                    <label class="form-label">Printer IP Address</label>
                                    <input type="text" name="printer_ip" class="form-control" placeholder="192.168.1.100" value="{{ get_setting('printer_ip') }}">
                                    <small class="text-muted">Sirf Network connection ke liye zaroori hai.</small>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="form-label">Port</label>
                                    <input type="text" name="printer_port" class="form-control" placeholder="9100" value="{{ get_setting('printer_port', '9100') }}">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Paper Width</label>
                                    <select name="printer_width" class="form-control">
                                        <option value="80" {{ get_setting('printer_width') == '80' ? 'selected' : '' }}>80mm (Standard)</option>
                                        <option value="58" {{ get_setting('printer_width') == '58' ? 'selected' : '' }}>58mm (Small)</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Auto-Print Receipt</label>
                                    <div class="form-check form-switch mt-2">
                                        <input class="form-check-input" type="checkbox" name="auto_print" value="1" {{ get_setting('auto_print') ? 'checked' : '' }}>
                                        <label class="form-check-label">Print after every order</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Save Printer Configuration</button>
                                <button type="button" class="btn btn-outline-secondary" onclick="alert('Testing connection...')">Test Print</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endsection