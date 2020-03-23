﻿/*
 Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/
(function() {
    function e(a, b, c) {
        this.editor = a;
        this.notification = null;
        this._message = new CKEDITOR.template(b);
        this._singularMessage = c ? new CKEDITOR.template(c) : null;
        this._tasks = [];
        this._doneTasks = this._doneWeights = this._totalWeights = 0
    }

    function d(a) {
        this._weight = a || 1;
        this._doneWeight = 0;
        this._isCanceled = !1
    }
    CKEDITOR.plugins.add("notificationaggregator", {
        requires: "notification"
    });
    e.prototype = {
        createTask: function(a) {
            a = a || {};
            var b = !this.notification,
                c;
            b && (this.notification = this._createNotification());
            c = this._addTask(a);
            c.on("updated", this._onTaskUpdate, this);
            c.on("done", this._onTaskDone, this);
            c.on("canceled", function() {
                this._removeTask(c)
            }, this);
            this.update();
            b && this.notification.show();
            return c
        },
        update: function() {
            this._updateNotification();
            this.isFinished() && this.fire("finished")
        },
        getPercentage: function() {
            return 0 === this.getTaskCount() ? 1 : this._doneWeights / this._totalWeights
        },
        isFinished: function() {
            return this.getDoneTaskCount() === this.getTaskCount()
        },
        getTaskCount: function() {
            return this._tasks.length
        },
        getDoneTaskCount: function() {
            return this._doneTasks
        },
        _updateNotification: function() {
            this.notification.update({
                message: this._getNotificationMessage(),
                progress: this.getPercentage()
            })
        },
        _getNotificationMessage: function() {
            var a = this.getTaskCount(),
                b = {
                    current: this.getDoneTaskCount(),
                    max: a,
                    percentage: Math.round(100 * this.getPercentage())
                };
            return (1 == a && this._singularMessage ? this._singularMessage : this._message).output(b)
        },
        _createNotification: function() {
            return new CKEDITOR.plugins.notification(this.editor, {
                type: "progress"
            })
        },
        _addTask: function(a) {
            a = new d(a.weight);
            this._tasks.push(a);
            this._totalWeights += a._weight;
            return a
        },
        _removeTask: function(a) {
            var b = CKEDITOR.tools.indexOf(this._tasks, a); - 1 !== b && (a._doneWeight && (this._doneWeights -= a._doneWeight), this._totalWeights -= a._weight, this._tasks.splice(b, 1), this.update())
        },
        _onTaskUpdate: function(a) {
            this._doneWeights += a.data;
            this.update()
        },
        _onTaskDone: function() {
            this._doneTasks += 1;
            this.update()
        }
    };
    CKEDITOR.event.implementOn(e.prototype);
    d.prototype = {
        done: function() {
            this.update(this._weight)
        },
        update: function(a) {
            if (!this.isDone() &&
                !this.isCanceled()) {
                a = Math.min(this._weight, a);
                var b = a - this._doneWeight;
                this._doneWeight = a;
                this.fire("updated", b);
                this.isDone() && this.fire("done")
            }
        },
        cancel: function() {
            this.isDone() || this.isCanceled() || (this._isCanceled = !0, this.fire("canceled"))
        },
        isDone: function() {
            return this._weight === this._doneWeight
        },
        isCanceled: function() {
            return this._isCanceled
        }
    };
    CKEDITOR.event.implementOn(d.prototype);
    CKEDITOR.plugins.notificationAggregator = e;
    CKEDITOR.plugins.notificationAggregator.task = d
})();