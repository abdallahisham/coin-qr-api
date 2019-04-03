<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionAggregateRootDomainMessagesTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_aggregate_root_domain_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('event_id', 36);
            $table->string('event_type', 100);
            $table->string('aggregate_root_id', 36)->nullable()->index('aggregate_root_id', 'aggregate_root_id.index');
            $table->dateTime('recorded_at', 6)->index();
            $table->text('payload');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_aggregate_root_domain_messages');
    }
}
