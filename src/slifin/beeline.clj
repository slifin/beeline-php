(ns slifin.beeline
  (:require [honeysql.core :as sql]
            [cognitect.transit :as transit]))


(def input (-> System/in
               (transit/reader :json)
               transit/read))

(def result (->> input (apply sql/format)))

(def writer (transit/writer System/out :json))

(transit/write writer result)
