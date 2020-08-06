(ns slifin.beeline
  (:require [honeysql.core :as sql]
            [cognitect.transit :as transit]))


(def input (-> System/in
               (transit/reader :json)
               transit/read))

(->> input (apply sql/format) prn)
