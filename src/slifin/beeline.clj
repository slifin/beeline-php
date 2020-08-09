(ns slifin.beeline
  (:require [honeysql.core :as sql]
            [cognitect.transit :as transit]))

(->> (-> System/in (transit/reader :json) transit/read)
     (apply sql/format)
     (transit/write (transit/writer System/out :json)))